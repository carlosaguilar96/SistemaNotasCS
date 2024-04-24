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
use App\Models\Notas;
use Illuminate\Database\QueryException;

class ProfesorController extends Controller
{
    //función para mostrar la vista para crear un profesor
    public function crearProfesor()
    {
        //Validar que el inicio se mostrará al administrador solamente
        if (!session()->has('administrador')) {
            abort('403');
        }

        //se seleccionan de la bd las materias que el docente puede impartir
        $materias = DB::table('materia')->orderBy('nombreMateria', 'asc')->get();
        return view('profesor.crear', compact('materias'));
    }

    //funcion para insertar un profesor a la bd
    public function storeProfesor(Request $request)
    {
        //Validar que el inicio se mostrará al administrador solamente
        if (!session()->has('administrador')) {
            abort('403');
        }

        //validaciones para los campos del formulario
        $validator = Validator::make($request->all(), [
            'dui' => ['required', 'min:10', 'unique:profesor'],
            'carnet' => ['required', 'unique:profesor', 'regex:/^[a-z]+\.[a-z]+$/'],
            'nombre' => ['required', 'string'],
            'apellido' => ['required', 'string'],
            'correo' => ['required', 'email', 'unique:profesor'],
            'foto' => ['required', 'image']
        ]);

        //validaciones para los checkbox
        $validator->after(function ($validator) use ($request) {
            if (!isset($_POST['materias'])) {
                $validator->errors()->add('materias', 'Debe seleccionar 1 o más materias');
            }
        });

        //en caso de existir errores con el ingreso de datos, se detiene la función
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //si no existen errores con el ingreso de datos, intenta insertar a la bd
        DB::beginTransaction();
        try {
            /*creación de nuevo objeto de tipo Profesor para guardar la información del formulario
              cada dato se guarda directo al objeto, excepto la imagen, a la cual se le asigna un nuevo nombre
              y se guarda una copia en la carpeta public/img/fotosP, el nuevo nombre es el que se guarda en la bd*/
            $profesor = new Profesor();
            $profesor->DUI = $request->input('dui');
            $profesor->carnet = $request->input('carnet');
            $profesor->nombres = $request->input('nombre');
            $profesor->apellidos = $request->input('apellido');
            $profesor->correo = $request->input('correo');
            $fileName = time() . "." . $request->file('foto')->extension();
            $request->file('foto')->move(public_path("img/fotosP"), $fileName);
            $profesor->foto = $fileName;
            $profesor->estadoEliminacion = 1;
            /*intento de guardar los datos en la bd, si es correcto, se guardan el id del profesor y las materias que puede
              impartir en la tabla detalleprofesormateria, además, se le genera una contraseña para el acceso al sistema y
              se guarda junto al carnet como nombre de usuario y el correo para acceder al sistema, así como el nivel (1), 
              finalmente se envía la información necesaria al correo del profesor */
            if ($profesor->save()) {
                foreach ($_POST['materias'] as $idMateria) {
                    $detalle = new DetalleProfesorMateria();
                    $detalle->idProfesor = $request->input('dui');
                    $detalle->idMateria = $idMateria;
                    $detalle->save();
                }

                $correo = $request->input('correo');
                $nombre = $request->input('nombre') . ' ' . $request->input('apellido');
                $usuario = $request->input('carnet');
                $permittedChars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $pass = '';
                $strength = 10;

                $stringLenght = strlen($permittedChars);

                for ($i = 0; $i < $strength; $i++) {
                    $randomCharacter = $permittedChars[mt_rand(0, $stringLenght - 1)];
                    $pass .= $randomCharacter;
                }
                $contraseña = Hash('SHA256', $pass);
                $user = new Usuario();
                $user->usuario = $usuario;
                $user->correo = $correo;
                $user->contraseña = $contraseña;
                $user->nivel = 1;
                $user->save();

                Mail::to($correo)->send(new Credenciales($nombre, $usuario, $pass));
                DB::commit();
                return to_route('admin.gestionUsuarios')->with('exitoAgregarProfesor', 'El profesor ha sido registrado exitosamente.');
            } else {
                DB::rollback();
                return to_route('admin.crearProfesor')->with('errorAgregarProfesor', 'Error al ingresar profesor. Intente otra vez.');
            }
        } catch (Exception $e) {
            DB::rollback();
            return to_route('admin.crearProfesor')->with('errorAgregarProfesor', 'Error al ingresar profesor. Intente otra vez.');
        }
    }

    public function index()
    {
        //Validar que el inicio se mostrará al administrador solamente
        if (!session()->has('administrador')) {
            abort('403');
        }

        $profesoresActivos = DB::table('profesor')->where('estadoEliminacion', '=', 1)->orderBy('apellidos', 'asc')->get();
        $profesoresInactivos = DB::table('profesor')->where('estadoEliminacion', '=', 0)->orderBy('apellidos', 'asc')->get();

        return view('profesor.index', compact('profesoresActivos', 'profesoresInactivos'));
    }

    public function show(string $id)
    {
        //Validar que el inicio se mostrará al administrador solamente
        if (!session()->has('administrador')) {
            abort('403');
        }

        $profesor = DB::table('profesor')
            ->where('DUI', '=', $id)->get();

        $informacion = DB::table('detalleprofesormateria')
            ->join('materia', 'detalleprofesormateria.idMateria', '=', 'materia.idMateria')
            ->where('detalleprofesormateria.idProfesor', '=', $id)
            ->get();

        $materiasDisponibles = DB::table('materia')
            ->whereNotExists(function ($subquery) use ($id) {
                $subquery
                    ->select('idMateria')
                    ->from('detalleprofesormateria')
                    ->whereColumn('materia.idMateria', 'detalleprofesormateria.idMateria')
                    ->where('idProfesor', '=', $id);
            })->get();

        return view('profesor.show', compact('profesor', 'informacion', 'materiasDisponibles'));
    }

    public function getProfesor(string $id)
    {
        //Validar que el inicio se mostrará al administrador solamente
        if (!session()->has('administrador')) {
            abort('403');
        }

        $profesor = Profesor::find($id);
        return $profesor;
    }

    public function getProfesorMateria(int $id)
    {
        //Validar que el inicio se mostrará al administrador solamente
        if (!session()->has('administrador')) {
            abort('403');
        }

        $detalle = DB::table('detalleprofesormateria')
            ->join('materia', 'detalleprofesormateria.idMateria', '=', 'materia.idMateria')
            ->where('idDetalle', '=', $id)
            ->get();
        return $detalle[0];
    }

    public function agregarDetallePM(Request $request)
    {
        //Validar que el inicio se mostrará al administrador solamente
        if (!session()->has('administrador')) {
            abort('403');
        }

        $validator = Validator::make($request->all(), [
            'materias' => ['required'],
        ]);
        //Validaciones extra para elementos select
        $validator->after(function ($validator) use ($request) {
            if ($request->input('materias') == 0) {
                $validator->errors()->add('materia', 'No se ha seleccionado materia');
            }
        });

        if ($validator->fails()) {
            return to_route('admin.showProfesor', $request->input('idProfesor'))->with('errorAgregarMateria', 'No se ha seleccionado materia para agregar a profesor');
        }

        DB::beginTransaction();
        try {
            $detalle = new DetalleProfesorMateria();
            $detalle->idProfesor = $request->input('idProfesor');
            $detalle->idMateria = $request->input('materias');
            $detalle->save();
            DB::commit();
            return to_route('admin.showProfesor', $request->input('idProfesor'))->with('exitoAgregarMateria', 'La materia ha sido agregada correctamente');
        } catch (Exception $e) {
            DB::rollBack();
            return to_route('admin.showProfesor', $request->input('idProfesor'))->with('errorAgregarMateria', 'La materia no ha sido agregada correctamente');
        }
    }

    public function deleteMateria(Request $request)
    {
        //Validar que el inicio se mostrará al administrador solamente
        if (!session()->has('administrador')) {
            abort('403');
        }

        try {
            $id = $request->input('idA');
            DB::table('detalleProfesorMateria')->where('idDetalle', $id)->delete();
            return to_route('admin.showProfesor', $request->input('dui'))->with('exitoEliminacion', 'La materia ha sido eliminada exitosamente.');
        } catch (Exception $e) {
            return to_route('admin.showProfesor', $request->input('dui'))->with('errorEliminacion', 'Ha ocurrido un error al eliminar la materia.');
        }
    }

    public function update(Request $request)
    {
        //Validar que el inicio se mostrará al administrador solamente
        if (!session()->has('administrador')) {
            abort('403');
        }

        $id = $request->input('dui');
        //validaciones para los campos del formulario
        $validator = Validator::make($request->all(), [
            'nombre' => ['required', 'string'],
            'apellido' => ['required', 'string'],
            'correo' => ['required', 'email'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('errorModificar', 'Ha ocurrido un error al actualizar la información.');
        }
        //intenta actualizar la información del profesor
        try {
            DB::table('profesor')->where('DUI', '=', $id)->update(
                [
                    'nombres' => $request->nombre,
                    'apellidos' => $request->apellido,
                    'correo' => $request->correo,
                ]
            );
            return to_route('admin.showProfesor', $id)->with('exitoModificar', 'La información del profesor ha sido actualizada.');
        } catch (QueryException $e) {
            return to_route('admin.showProfesor', $id)->with('errorModificar', 'Ha ocurrido un error al actualizar la información.');
        }
    }

    public function updateFoto(Request $request)
    {
        //Validar que el inicio se mostrará al administrador solamente
        if (!session()->has('administrador')) {
            abort('403');
        }

        $id = $request->input('id');
        $profesor = Profesor::find($id);
        $fotoEliminar = $profesor->foto;

        //validaciones para los campos del formulario
        $validator = Validator::make($request->all(), [
            'foto' => ['required', 'image']
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('errorModificarFoto', 'Ha ocurrido un error al actualizar la foto.');
        }
        //intenta actualizar la foto del estudiante
        try {
            $fileName = time() . "." . $request->file('foto')->extension();
            $request->file('foto')->move(public_path("img/fotosP"), $fileName);
            DB::table('profesor')->where('DUI', '=', $id)->update(
                [
                    'foto' => $fileName,
                ]
            );
            //elimina la foto anterior
            unlink(public_path("img/fotosP/" . $fotoEliminar));
            return to_route('admin.showProfesor', $id)->with('exitoModificarFoto', 'La foto del profesor ha sido actualizada.');
        } catch (QueryException $e) {
            return to_route('admin.showProfesor', $id)->with('errorModificarFoto', 'Ha ocurrido un error al actualizar la foto.');
        }
    }

    public function delete(Request $request)
    {
        //Validar que el inicio se mostrará al administrador solamente
        if (!session()->has('administrador')) {
            abort('403');
        }

        try {
            $id = $request->input('id');
            DB::table('profesor')->where('DUI', $id)->update(['estadoeliminacion' => 0]);
            return to_route('admin.indexProfesores')->with('exitoEliminacion', 'El profesor ha sido eliminado exitosamente.');
        } catch (Exception $e) {
            return to_route('admin.indexProfesores')->with('errorEliminacion', 'Ha ocurrido un error al eliminar el profesor.');
        }
    }

    public function restore(Request $request)
    {
        //Validar que el inicio se mostrará al administrador solamente
        if (!session()->has('administrador')) {
            abort('403');
        }

        try {
            $id = $request->input('idR');
            DB::table('profesor')->where('DUI', $id)->update(['estadoeliminacion' => 1]);
            return to_route('admin.indexProfesores')->with('exitoReactivar', 'El profesor se ha reactivado exitosamente.');
        } catch (Exception $e) {
            return to_route('admin.indexProfesores')->with('errorReactivar', 'Ha ocurrido un error al reactivar el profesor.');
        }
    }

    //función para mostrar la vista de inicio del sitio profesor
    public function inicio()
    {
        if (session()->has('profesor')) {
            $profesor = session()->get('profesor');
            //formando un array con los grupos que el profesor tiene en el año actual
            //agregando a la sesión si es encargado de una sección
            $año = DB::table('añoescolar')->where('estadoFinalizacion', '=', 0)->get();
            if (!empty($año[0])) {
                $grupos = DB::table('detalleseccionmateria')
                    ->join('secciones', 'detalleseccionmateria.idSeccion', '=', 'secciones.idSeccion')
                    ->join('materia', 'detalleseccionmateria.idMateria', '=', 'materia.idMateria')
                    ->where('idAño', '=', $año[0]->idAño)
                    ->where('idProfesor', '=', $profesor[0]->DUI)
                    ->get();
                if (count($grupos) > 0) {
                    $ArregloGrupos = [];
                    foreach ($grupos as $grupo) {
                        $ArregloGrupos[] = $grupo->idDetalle;
                    }
                    session()->put('grupos', $grupos);
                    session()->put('ArregloGrupos', $ArregloGrupos);
                }
                $seccionEncargado = DB::table('secciones')
                    ->where('idAño', '=', $año[0]->idAño)
                    ->where('encargado', '=', $profesor[0]->DUI)->get();
                if (count($seccionEncargado) == 1) {
                    session()->put('SeccionEncargado', $seccionEncargado);
                    session()->put('SeccionEncargadoID', $seccionEncargado[0]->idSeccion);
                }
            }
            return view('sitioProfesor.inicio', compact('profesor'));
        } else {
            abort('403');
        }
    }

    public function cambiarContraseñaProfe()
    {
        if (!session()->has('profesor')) {
            abort('403');
        }
        return view('sitioProfesor.cambiarContraseña');
    }

    public function cambiarContraseñaProfesor(Request $request)
    {

        if (!session()->has('profesor')) {
            abort('403');
        }

        $request->validate([
            'ContraseñaActual' => ['required'],
            'NuevaContraseña' => ['required', 'confirmed', 'min:10'],
        ]);

        $info = session()->get('profesor');
        $user = DB::table('usuarios')->where('usuario', '=', $info[0]->carnet)->get();

        $passwordActual = $request->input('ContraseñaActual');
        $passwordNueva = $request->input('NuevaContraseña');
        $passwordNueva1 = $request->input('NuevaContraseña_confirmation');

        if ($user[0]->contraseña == Hash('SHA256', $passwordActual)) {
            $contra = Hash('SHA256', $passwordNueva);
            try {
                DB::table('usuarios')->where('usuario', '=', $info[0]->carnet)->update(['contraseña' => $contra]);
                return to_route('profesor.cambiarContraseñaProfe')->with('exitoCambiar', 'La contraseña del usuario ha sido cambiada con éxito');
            } catch (Exception $e) {
                return to_route('profesor.cambiarContraseñaProfe')->with('errorCambiar', 'La contraseña del usuario no sido cambiada con éxito');
            }
        } else {
            return to_route('profesor.cambiarContraseñaProfe')->with('errorCambiar', 'La contraseña del usuario no sido cambiada con éxito');
        }
    }

    public function agregarNotas(int $evaluacion, int $grupo)
    {
        if (!session()->has('profesor')) {
            abort('403');
        }
        $grupo = DB::table('detalleseccionmateria')
            ->join('secciones', 'detalleseccionmateria.idSeccion', '=', 'secciones.idSeccion')
            ->join('materia', 'detalleseccionmateria.idMateria', '=', 'materia.idMateria')
            ->where('idDetalle', '=', $grupo)->get();
        //verificando que el grupo exista
        if (!empty($grupo[0])) {
            //verificando que el grupo pertenezca al profesor
            if (in_array($grupo[0]->idDetalle, session()->get('ArregloGrupos'))) {
                $año = DB::table('añoescolar')->where('estadoFinalizacion', '=', 0)->get();
                $periodo = DB::table('periodos')->where('estado', '=', 1)->get();
                $totalEstudiantes = DB::table('detalleseccionestudiante')->where('idSeccion', '=', $grupo[0]->idSeccion)->count();
                $estudiantes = DB::table('detalleseccionestudiante')
                    ->join('estudiante', 'detalleseccionestudiante.idEstudiante', '=', 'estudiante.NIE')
                    ->where('idSeccion', '=', $grupo[0]->idSeccion)
                    ->get();
                $eval = DB::table('evaluacion')->where('idEvaluacion','=',$evaluacion)->get();

                return view('notas.index', compact('grupo', 'año', 'periodo', 'totalEstudiantes', 'estudiantes', 'evaluacion', 'eval'));
            } else {
                abort('403');
            }
        } else {
            abort('404');
        }
    }

    public function insertarNotas(Request $request)
    {
        if (!session()->has('profesor')) {
            abort('403');
        }

        $request->validate([
            'notas.*' => ['required', 'numeric', 'min:0', 'max:10'],
        ]);

        DB::beginTransaction();
        try {
            $notas = $request->input('notas');
            $estudiantes = $request->input('estudiantes');
            foreach ($notas as $indice => $nota) {
                $detalle = new Notas();
                $idDetalleEstudiante = $estudiantes[$indice];
                $detalle->idEvaluacion = $request->input('idEvaluacion');
                $detalle->nota = $nota;
                $detalle->idDetalleEstudiante = $idDetalleEstudiante;
                $detalle->idDetalleMateria = $request->input('idDetalleMateria');
                $detalle->idPeriodo = $request->input('idPeriodo');
                $detalle->save();
            }
            DB::commit();
            return to_route('profesor.showGrupo', $request->input('idDetalleMateria'))->with('exitoAgregarNotas', 'Las notas han sido agregadas exitosamente');
        } catch (Exception $e) {
            DB::rollBack();
            return to_route('profesor.showGrupo', $request->input('idDetalleMateria'))->with('errorAgregarNotas', 'Hubo un error al ingresar las notas');
        }
    }

    public function mostrarNotas(int $evaluacion, int $idgrupo)
    {
        if (!session()->has('profesor')) {
            abort('403');
        }
        $grupo = DB::table('detalleseccionmateria')
            ->join('secciones', 'detalleseccionmateria.idSeccion', '=', 'secciones.idSeccion')
            ->join('materia', 'detalleseccionmateria.idMateria', '=', 'materia.idMateria')
            ->where('idDetalle', '=', $idgrupo)->get();
        //verificando que el grupo exista
        if (!empty($grupo[0])) {
            //verificando que el grupo pertenezca al profesor
            if (in_array($grupo[0]->idDetalle, session()->get('ArregloGrupos'))) {
                $año = DB::table('añoescolar')->where('estadoFinalizacion', '=', 0)->get();
                $periodo = DB::table('periodos')->where('estado', '=', 1)->get();
                $notas = DB::table('nota')->join('detallegradoestudiante', 'nota.idDetalleEstudiante','=','detallegradoestudiante.idDetalle')
                                           ->join('estudiante', 'detallegradoestudiante.idEstudiante','=','estudiante.NIE')
                                           ->where('idEvaluacion','=',$evaluacion)
                                           ->where('idDetalleMateria','=',$idgrupo)
                                           ->get();
                $eval = DB::table('evaluacion')->where('idEvaluacion','=',$evaluacion)->get();

                return view('notas.update', compact('idgrupo', 'año', 'periodo', 'evaluacion', 'notas', 'eval','grupo'));
            } else {
                abort('403');
            }
        } else {
            abort('404');
        }
    }

    public function updateNotas(Request $request){
        if (!session()->has('profesor')) {
            abort('403');
        }
        try{
            $idNota = $request->input('notaA');
            $nota = $request->input('nota');
            DB::table('nota')->where('idNota', '=', $idNota)->update(
                [
                    'nota' => $nota,
                ]
            );
            return to_route('profesor.mostrarNotas', [$request->input('evaluacion'), $request->input('grupo')])->with('exitoModificarNotas', 'Las notas han sido modificadas exitosamente');
        }catch(Exception $e){
            return to_route('profesor.mostrarNotas', [$request->input('evaluacion'), $request->input('grupo')])->with('errorModificarNotas', 'Las notas no han sido modificadas exitosamente');
        }
    }
    
    public function getNota(int $id)
    {
        if (!session()->has('profesor')) {
            abort('403');
        }

        $nota = Notas::find($id);
        return $nota;
    }
}
