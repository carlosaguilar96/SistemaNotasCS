<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Profesor;
use App\Models\Usuario;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\Mail\Credenciales;
use App\Models\DetalleProfesorMateria;

class ProfesorController extends Controller
{
    //función para mostrar la vista para crear un profesor
    public function crearProfesor(){
        //se seleccionan de la bd las materias que el docente puede impartir
        $materias = DB::table('materia')->get();
        return view('profesor.crear',compact('materias'));
    }

    //funcion para insertar un profesor a la bd
    public function storeProfesor(Request $request){
        //validaciones para los campos del formulario
        $validator = Validator::make($request->all(), [
            'dui' => ['required','min:10','unique:profesor'],
            'carnet' => ['required','unique:profesor','regex:/^[a-z]+\.[a-z]+$/'],
            'nombre' => ['required','string'],
            'apellido' => ['required', 'string'],
            'correo' => ['required', 'email', 'unique:profesor'],            
            'foto'=> ['required','image']
        ]);

        //validaciones para los checkbox
        $validator->after(function($validator) use($request){
            if(!isset($_POST['materias'])){
                $validator->errors()->add('materias','Debe seleccionar 1 o más materias');
            }
        });

        //en caso de existir errores con el ingreso de datos, se detiene la función
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //si no existen errores con el ingreso de datos, intenta insertar a la bd
        DB::beginTransaction();
        try{
            /*creación de nuevo objeto de tipo Profesor para guardar la información del formulario
              cada dato se guarda directo al objeto, excepto la imagen, a la cual se le asigna un nuevo nombre
              y se guarda una copia en la carpeta public/img/fotosP, el nuevo nombre es el que se guarda en la bd*/
            $profesor = new Profesor();
            $profesor->DUI = $request->input('dui');
            $profesor->carnet = $request->input('carnet');
            $profesor->nombres = $request->input('nombre');
            $profesor->apellidos = $request->input('apellido');
            $profesor->correo = $request->input('correo');
            $fileName = time().".".$request->file('foto')->extension();
            $request->file('foto')->move(public_path("img/fotosP"),$fileName);
            $profesor->foto = $fileName;
            $profesor->estadoEliminacion = 1;
            /*intento de guardar los datos en la bd, si es correcto, se guardan el id del profesor y las materias que puede
              impartir en la tabla detalleprofesormateria, además, se le genera una contraseña para el acceso al sistema y
              se guarda junto al carnet como nombre de usuario y el correo para acceder al sistema, así como el nivel (1), 
              finalmente se envía la información necesaria al correo del profesor */
              if($profesor->save()){
                foreach($_POST['materias'] as $idMateria){
                    $detalle = new DetalleProfesorMateria();
                    $detalle->idProfesor = $request->input('dui');
                    $detalle->idMateria = $idMateria;
                    $detalle->save();
                }
                
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
                $user->nivel = 1;
                $user->save();

                Mail::to($correo)->send(new Credenciales($nombre, $usuario, $pass));
                DB::commit();
                return to_route('admin.gestionUsuarios')->with('exitoAgregarProfesor','El profesor ha sido registrado exitosamente.');
            } else{
                DB::rollback();
                return to_route('admin.crearProfesor')->with('errorAgregarProfesor','Error al ingresar profesor. Intente otra vez.');
            }
        }
         catch(Exception $e){
            DB::rollback();
            return to_route('admin.crearProfesor')->with('errorAgregarProfesor','Error al ingresar profesor. Intente otra vez.');
        }
    }
    
}