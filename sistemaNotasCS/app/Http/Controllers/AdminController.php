<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Administrador;
use App\Models\Usuario;
use Illuminate\Support\Facades\Mail;
use App\Mail\Credenciales;
use Exception;
use Illuminate\Database\QueryException;

class AdminController extends Controller
{
    //función para mostrar la vista de inicio del sitio administrador
    public function inicio(){
        return view('sitioAdmin.inicio');
    }

    //función para mostrar la vista de gestión de usuarios
    public function gestionUsuarios(){
        return view('sitioAdmin.gestionUsuarios');
    }

    //función para mostrar la vista de gestión de grados
    public function gestionGrados(){
        return view('sitioAdmin.gestionGrados');
    }

    //función para mostrar la vista de creación de administradores
    public function creacionAdmin(){
        return view('admin.crear');
    }

    //funcion para insertar un profesor a la bd
    public function storeAdmin(Request $request){
        //validaciones para los campos del formulario
        $validator = Validator::make($request->all(), [
            'dui' => ['required','min:10','unique:administrador'],
            'carnet' => ['required','unique:administrador','regex:/^[a-z]+\.[a-z]+$/'],
            'nombre' => ['required','string'],
            'apellido' => ['required', 'string'],
            'correo' => ['required', 'email', 'unique:administrador'],            
            'foto'=> ['required','image']
        ]);

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
            $administrador = new Administrador();
            $administrador->DUI = $request->input('dui');
            $administrador->carnet = $request->input('carnet');
            $administrador->nombres = $request->input('nombre');
            $administrador->apellidos = $request->input('apellido');
            $administrador->correo = $request->input('correo');
            $fileName = time().".".$request->file('foto')->extension();
            $request->file('foto')->move(public_path("img/fotosA"),$fileName);
            $administrador->foto = $fileName;
            $administrador->estadoEliminacion = 1;
            /*intento de guardar los datos en la bd, si es correcto, se guardan el id del profesor y las materias que puede
              impartir en la tabla detalleprofesormateria, además, se le genera una contraseña para el acceso al sistema y
              se guarda junto al carnet como nombre de usuario y el correo para acceder al sistema, así como el nivel (0), 
              finalmente se envía la información necesaria al correo del profesor */
              if($administrador->save()){
                
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
                $user->nivel = 0;
                $user->save();

                Mail::to($correo)->send(new Credenciales($nombre, $usuario, $pass));
                DB::commit();
                return to_route('admin.gestionUsuarios')->with('exitoAgregarAdministrador','El Administrador ha sido registrado exitosamente.');
            } else{
                DB::rollback();
                return to_route('admin.crearAdmin')->with('errorAgregarAdministrador','Error al ingresar administrador. Intente otra vez.');
            }
        }
         catch(Exception $e){
            DB::rollback();
            return to_route('admin.crearAdmin')->with('errorAgregarAdmin','Error al ingresar administrador. Intente otra vez.');
        }
    }

    public function index(){
        $administradoresActivos = DB::table('administrador')->where('estadoEliminacion','=',1)->orderBy('apellidos','asc')->get();
        $administradoresInactivos = DB::table('administrador')->where('estadoEliminacion','=',0)->orderBy('apellidos','asc')->get();
        return view('admin.index',compact('administradoresActivos','administradoresInactivos'));
    }

    public function show(string $id){
        $administrador = DB::table('administrador')
                        ->where('DUI','=',$id)->get();
        return view('admin.show', compact('administrador'));
    }

    public function getAdmin(string $id)
	{
		$administrador = Administrador::find($id);
		return $administrador;
	}

    public function delete(Request $request){
        try{
			$id = $request->input('id');
            DB::table('administrador')->where('DUI', $id)->update(['estadoeliminacion' => 0]);
			return to_route('admin.indexAdministradores')->with('exitoEliminacion','El administrador ha sido eliminado exitosamente.');
		}catch(Exception $e){
			return to_route('admin.indexAdministradores')->with('errorEliminacion','Ha ocurrido un error al eliminar el administrador.');
		}
    }

    public function update(Request $request){
        $id = $request->input('dui');
        //validaciones para los campos del formulario
        $validator = Validator::make($request->all(), [
            'nombre' => ['required','string'],
            'apellido' => ['required', 'string'],              
            'correo' => ['required', 'email'],            
        ]);

        if($validator->fails()){
            return redirect()->back()->with('errorModificar','Ha ocurrido un error al actualizar la información.');
        }
        //intenta actualizar la información del estudiante
        try{
            DB::table('administrador')->where('DUI','=',$id)->update(
                [
                    'nombres' => $request->nombre,
                    'apellidos' => $request->apellido,
                    'correo' => $request->correo,
                ]
            );
            return to_route('admin.showAdministrador',$id)->with('exitoModificar','La información del administrador ha sido actualizada.');            
        } catch(QueryException $e){
            return to_route('admin.showAdministrador',$id)->with('errorModificar','Ha ocurrido un error al actualizar la información.');
        }
    }

    public function restore(Request $request){
        try{
			$id = $request->input('idR');
            DB::table('administrador')->where('DUI', $id)->update(['estadoeliminacion' => 1]);
			return to_route('admin.indexAdministradores')->with('exitoReactivar','El estudiante se ha reactivado exitosamente.');
		}catch(Exception $e){
			return to_route('admin.indexAdministradores')->with('errorReactivar','Ha ocurrido un error al reactivar el estudiante.');
		}
    }

    public function updateFoto(Request $request){
        $id = $request->input('id');
        $profesor = Administrador::find($id);
        $fotoEliminar = $profesor->foto;

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
            $request->file('foto')->move(public_path("img/fotosA"),$fileName);
            DB::table('administrador')->where('DUI','=',$id)->update(
                [
                    'foto' => $fileName,
                ]
            );
            //elimina la foto anterior
            unlink(public_path("img/fotosA/".$fotoEliminar));
            return to_route('admin.showAdministrador',$id)->with('exitoModificarFoto','La foto del administrador ha sido actualizada.');            
        } catch(QueryException $e){
            return to_route('admin.showAdministrador',$id)->with('errorModificarFoto','Ha ocurrido un error al actualizar la foto.');
        }
    }
}