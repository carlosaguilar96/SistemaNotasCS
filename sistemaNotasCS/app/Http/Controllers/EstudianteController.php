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
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

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
            $estudiante->estadoFinalizacion = 0;
            /*intento de guardar los datos en la bd, si es correcto, se guarda el id del estudiante y el grado que cursará
              en la tabla detallegradoestudiante, además, se le genera una contraseña para el acceso al sistema y se guarda
              junto al carnet como nombre de usuario y el correo para acceder al sistema, así como el nivel (2), 
              finalmente se envía la información necesaria al correo del estudiante */
            if($estudiante->save()){
                $detalle = new DetalleGradoEstudiante();
                $detalle->idEstudiante = $request->input('nie');
                $detalle->idGrado = $request->input('grado');
                $detalle->estadoFinalizacion = 0;
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

    //función para mostrar la vista para gestión de estudiantes
    public function index(){
        $estudiantesActivos = DB::table('estudiante')->where('estadoEliminacion','=',1)->orderBy('apellidos','asc')->get();
        $estudiantesInactivos = DB::table('estudiante')->where('estadoEliminacion','=',0)->orderBy('apellidos','asc')->get();
        return view('estudiante.index',compact('estudiantesActivos','estudiantesInactivos'));
    }

    //función para mostrar información de un estudiante
    public function show(int $id){
        $grados = DB::table('grado')->JOIN('etapa','grado.idEtapa','=','etapa.idEtapa')->get();
        $estudiante = DB::table('estudiante')
                        ->where('NIE','=',$id)->get();
        if($estudiante[0]->estadoeliminacion==1){
            $gradoEstudiante = DB::table('detallegradoestudiante')
                        ->join('grado','detallegradoestudiante.idGrado','=','grado.idGrado')
                        ->join('etapa','grado.idEtapa','=','etapa.idEtapa')
                        ->where('idEstudiante','=',$id)->where('estadoFinalizacion','=',0)->get();
            if($gradoEstudiante[0]->idEtapa==1){
                $grado = $gradoEstudiante[0]->nombreGrado;
            } else{
                $grado = $gradoEstudiante[0]->nombreGrado.' '.$gradoEstudiante[0]->nombreEtapa;
            }
        } else{
            $grado = "Estudiante inactivo";
        }
        return view('estudiante.show', compact('estudiante','grado','grados'));
    }

    public function getStudent(int $id)
	{
		$estudiante = Estudiantes::find($id);
		return $estudiante;
	}

    public function update(Request $request){
        $id = $request->input('nie');
        //validaciones para los campos del formulario
        $validator = Validator::make($request->all(), [
            'nombre' => ['required','string'],
            'apellido' => ['required', 'string'],
            'fechaNacimiento' => ['required'],                
            'sexo' => ['required'],
            'correo' => ['required', 'email'],            
        ]);
        //validaciones extra para elementos select
        $validator->after(function($validator) use($request){
            if($request->input('sexo')==0){
                $validator->errors()->add('sexo','El campo sexo es obligatorio');
            }
        });
        if($validator->fails()){
            return redirect()->back()->with('errorModificar','Ha ocurrido un error al actualizar la información.');
        }
        //intenta actualizar la información del estudiante
        try{
            DB::table('estudiante')->where('NIE','=',$id)->update(
                [
                    'nombres' => $request->nombre,
                    'apellidos' => $request->apellido,
                    'fechaNacimiento' => $request->fechaNacimiento,
                    'sexo' => $request->sexo,
                    'correo' => $request->correo,
                ]
            );
            return to_route('admin.showEstudiante',$id)->with('exitoModificar','La información del estudiante ha sido actualizada.');            
        } catch(QueryException $e){
            return to_route('admin.showEstudiante',$id)->with('errorModificar','Ha ocurrido un error al actualizar la información.');
        }
    }

    public function updateFoto(Request $request){
        $id = $request->input('id');
        $estudiante = Estudiantes::find($id);
        $fotoEliminar = $estudiante->foto;

        //validaciones para los campos del formulario
        $validator = Validator::make($request->all(), [
            'foto'=> ['required','image']            
        ]);
        if($validator->fails()){
            return redirect()->back()->with('errorModificarFoto','Ha ocurrido un error al actualizar la foto.');
        }
        //intenta actualizar la foto del estudiante
        try{
            $fileName = time().".".$request->file('foto')->extension();
            $request->file('foto')->move(public_path("img/fotosE"),$fileName);
            DB::table('estudiante')->where('NIE','=',$id)->update(
                [
                    'foto' => $fileName,
                ]
            );
            //elimina la foto anterior
            unlink(public_path("img/fotosE/".$fotoEliminar));
            return to_route('admin.showEstudiante',$id)->with('exitoModificarFoto','La foto del estudiante ha sido actualizada.');            
        } catch(QueryException $e){
            return to_route('admin.showEstudiante',$id)->with('errorModificarFoto','Ha ocurrido un error al actualizar la foto.');
        }
    }

    public function delete(Request $request){
        try{
			$id = $request->input('id');
            DB::table('estudiante')->where('NIE', $id)->update(['estadoeliminacion' => 0]);
			return to_route('admin.indexEstudiantes')->with('exitoEliminacion','El estudiante ha sido eliminado exitosamente.');
		}catch(Exception $e){
			return to_route('admin.indexEstudiantes')->with('errorEliminacion','Ha ocurrido un error al eliminar el estudiante.');
		}
    }

    public function restore(Request $request){
        try{
			$id = $request->input('id');
            DB::table('estudiante')->where('NIE', $id)->update(['estadoeliminacion' => 1]);
			return to_route('admin.indexEstudiantes')->with('exitoReactivar','El estudiante se ha reactivado exitosamente.');
		}catch(Exception $e){
			return to_route('admin.indexEstudiantes')->with('errorReactivar','Ha ocurrido un error al reactivar el estudiante.');
		}
    }
}