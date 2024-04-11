<?php

namespace App\Http\Controllers;

use App\Mail\Credenciales;
use App\Models\Administrador;
use App\Models\Usuario;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //función para mostrar página de inicio
    //si no hay administradores registrados muestra la vista para crear primer administrador
    public function welcome(){
        if(session()->has('user')){
            session()->forget('user');
        }    
        if(session()->has('administrador')){
            session()->forget('administrador');            
        }
        $admins = DB::table('usuarios')->where('nivel','=',0)->count();
        if($admins > 0){
            return view('welcome');
        } else{
            return view('crearPrimerAdmin');
        }
    }

    //función para guardar primer administrador
    public function guardarPrimerAdmin(Request $request){
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
                return to_route('welcome')->with('exitoAgregarAdministrador','El primer administrador ha sido registrado correctamente.');
            } else{
                DB::rollback();
                return to_route('welcome')->with('errorAgregarAdministrador','Error al ingresar primer administrador. Intente otra vez.');
            }
        }
         catch(Exception $e){
            DB::rollback();
            return to_route('welcome')->with('errorAgregarAdministrador','Error al ingresar primer administrador. Intente otra vez.');
        }
    }

    //función para realizar login
    public function login(Request $request){
        $request->validate([
            'user' => ['required'],
            'password' => ['required']
        ]);
        try{
            $userName = $request->input("user");
            $pass = $request->input("password");

            $user = DB::table('usuarios')
                            ->where('usuario','=',$userName)
                            ->get();
                    
            if(!empty($user[0])){                                 
                if($user[0]->contraseña == Hash('SHA256',$pass)){
                    $nivel = $user[0]->nivel;
                    //Buscar que tipo de usuario es
                    if($nivel == 0){//Administrador
                        $adminCarnet = $user[0]->usuario;
                        $admin = DB::table('administrador')->where('carnet','=',$adminCarnet)->get();
                        if($admin[0]->estadoeliminacion == 1){
                            //Si no está eliminado, se crean variables de sesión con la información del usuario
                            $request->session()->put('user',$user); 
                            session()->put('administrador',$admin);
                            return to_route('admin.inicio');
                        }else{
                            return redirect()->back()->with('error','Acceso denegado');
                        }
                    }else{
                        return redirect()->back()->with('error','Acceso denegado');
                    }
                }else{
                    return redirect()->back()->with('error','Usuario y/o contraseña incorrectos');
                }
            } else{
                return redirect()->back()->with('error','Usuario y/o contraseña incorrectos');
            }
        }catch(Exception $e){
            return redirect()->back()->with('error','Error al iniciar sesión'.$e->getMessage());
        }
    }

    //función para realizar logout
    public function logout()
    {
        if(session()->has('user')){
            session()->forget('user');
        }
        if(session()->has('administrador')){
            session()->forget('administrador');            
        }
        
        return to_route('welcome');
    }
}