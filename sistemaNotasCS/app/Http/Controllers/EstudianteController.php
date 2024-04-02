<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Estudiantes;
use App\Models\DetalleGradoEstudiante;
use App\Models\Usuario;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\Mail\Credenciales;

class EstudianteController extends Controller
{
    //función para mostrar la vista para crear un estudiante
    public function crearEstudiante(){
        //se seleccionan de la bd los grados que ofrece el colegio para mostrar en el select
        $grados = DB::table('grado')->JOIN('etapa','grado.idEtapa','=','etapa.idEtapa')->get();
        return view('estudiante.crear',compact('grados'));
    }

    //funcion para insertar un estudiante a la bd
    public function storeEstudiante(Request $request){
        //validaciones para los campos del formulario
        $validator = Validator::make($request->all(), [
            'nie' => ['required','min:8','unique:estudiante'],
            'carnet' => ['required','min:8','unique:estudiante'],
            'nombre' => ['required','string'],
            'apellido' => ['required', 'string'],
            'fechaNacimiento' => ['required'],                
            'sexo' => ['required'],
            'correo' => ['required', 'email', 'unique:estudiante'],            
            'grado' => ['required'],
            'foto'=> ['required','image']
        ]);
        //validaciones extra para elementos select
        $validator->after(function($validator) use($request){
            if($request->input('sexo')==0){
                $validator->errors()->add('sexo','El campo sexo es obligatorio');
            }
            if($request->input('grado')==0){
                $validator->errors()->add('grado','El campo grado es obligatorio');
            }
        });
        //en caso de existir errores con el ingreso de datos, se detiene la función
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        //si no existen errores con el ingreso de datos, intenta insertar a la bd
        DB::beginTransaction();
        try{
            /*creación de nuevo objeto de tipo Estudiante para guardar la información del formulario
              cada dato se guarda directo al objeto, excepto la imagen, a la cual se le asigna un nuevo nombre
              y se guarda una copia en la carpeta public/img/fotosE, el nuevo nombre es el que se guarda en la bd*/
            $estudiante = new Estudiantes();
            $estudiante->NIE = $request->input('nie');
            $estudiante->carnet = $request->input('carnet');
            $estudiante->nombres = $request->input('nombre');
            $estudiante->apellidos = $request->input('apellido');
            $estudiante->fechaNacimiento = $request->input('fechaNacimiento');
            $estudiante->sexo = $request->input('sexo');
            $estudiante->correo = $request->input('correo');
            $fileName = time().".".$request->file('foto')->extension();
            $request->file('foto')->move(public_path("img/fotosE"),$fileName);
            $estudiante->foto = $fileName;
            $estudiante->estadoEliminacion = 1;
            /*intento de guardar los datos en la bd, si es correcto, se guarda el id del estudiante y el grado que cursará
              en la tabla detallegradoestudiante, además, se le genera una contraseña para el acceso al sistema y se guarda
              junto al carnet como nombre de usuario y el correo para acceder al sistema, así como el nivel (2), 
              finalmente se envía la información necesaria al correo del estudiante */
            if($estudiante->save()){
                $detalle = new DetalleGradoEstudiante();
                $detalle->idEstudiante = $request->input('nie');
                $detalle->idGrado = $request->input('grado');
                $detalle->save();

                $correo = $request->input('correo');
                $nombre = $request->input('nombre').' '.$request->input('apellido');
                $usuario = $request->input('carnet');
                $permittedChars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		        $pass = '';
		        $strength = 10;

		        $stringLenght = strlen($permittedChars);

		        for($i = 0; $i < $strength; $i++) {
		        	$randomCharacter = $permittedChars[mt_rand(0, $stringLenght - 1)];
		        	$pass .= $randomCharacter;
		        }
                $contraseña = Hash('SHA256',$pass);
                $user = new Usuario();
                $user->usuario = $usuario;
                $user->correo = $correo;
                $user->contraseña = $contraseña;
                $user->nivel = 2;
                $user->save();

                Mail::to($correo)->send(new Credenciales($nombre, $usuario, $pass));
                DB::commit();
                return to_route('admin.gestionUsuarios')->with('exitoAgregarEstudiante','El estudiante ha sido registrado exitosamente.');
            } else{
                DB::rollback();
                return to_route('admin.crearEstudiante')->with('errorAgregarEstudiante','Error al ingresar estudiante. Intente otra vez.');
            }  
        } catch(Exception $e){
            DB::rollback();
            return to_route('admin.crearEstudiante')->with('errorAgregarEstudiante','Error al ingresar estudiante. Intente otra vez.');
        }
    }
}