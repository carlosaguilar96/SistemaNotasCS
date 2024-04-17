<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DetalleSeccionEstudiante;
use App\Models\DetalleSeccionMateria;
use App\Models\Seccion;
use Carbon\Exceptions\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SeccionController extends Controller
{
    public function index(int $id){
        if(!session()->has('administrador')){
            abort('403');
        }
        $secciones = DB::table('secciones')->where('idAño','=',$id)->get();
        $grados = DB::table('grado')->join('etapa','grado.idEtapa','=','etapa.idEtapa')->get();
        $encargados = DB::table('profesor')
                                ->whereNotExists(function($subquery) use($id){
                                    $subquery
                                    ->select('DUI')
                                    ->from('secciones')
                                    ->whereColumn('profesor.DUI','secciones.encargado')
                                    ->where('idAño','=',$id);
                                })->get();
        return view('secciones.index', compact('secciones','grados','encargados', 'id'));
    }

    public function store(Request $request){
        if(!session()->has('administrador')){
            abort('403');
        }
        //validaciones para los campos del formulario
        $validator = Validator::make($request->all(), [
            'nombre' => ['required'],
            'grado' => ['required'],
            'encargado' => ['required']
        ]);
        //validaciones extra para elementos select
        $validator->after(function($validator) use($request){
            if($request->input('grado')==0){
                $validator->errors()->add('sexo','El campo sexo es obligatorio');
            }
            if($request->input('encargado')==0){
                $validator->errors()->add('grado','El campo grado es obligatorio');
            }
        });
        //en caso de existir errores con el ingreso de datos, se detiene la función
        if($validator->fails()){
            return to_route('admin.indexSecciones',$request->input('año'))->with('errorSeccion','Error en el ingreso de datos.');
        }
        DB::beginTransaction();
        try{
            $idSeccion = DB::table('secciones')->insertGetId([
                'nombreSeccion' => $request->input('nombre'),
                'encargado' => $request->input('encargado'),
                'idGrado' => $request->input('grado'),
                'idAño' => $request->input('año'),
                'estadoeliminacion' => 0,
            ]);
            $materias = DB::table('detallegradomateria')->where('idGrado','=',$request->input('grado'))->get();
            foreach($materias as $materia){
                $detalle = new DetalleSeccionMateria();
                $detalle->idMateria = $materia->idMateria;
                $detalle->idSeccion = $idSeccion;
                $detalle->save();
            }
            DB::commit();
            return to_route('admin.indexSecciones',$request->input('año'))->with('exitoSeccion','Se ha creado la sección '.$request->input('nombre'));
        } catch(Exception $e){
            DB::rollback();
            return to_route('admin.indexSecciones',$request->input('año'))->with('errorSeccion','Error al crear la seccion.');
        }
    }

    public function show(int $id){
        if(!session()->has('administrador')){
            abort('403');
        }
        $seccion = DB::table('secciones')->join('añoEscolar','secciones.idAño','=','añoEscolar.idAño')
                                         ->join('profesor','secciones.encargado','=','profesor.DUI')
                                         ->where('idSeccion','=',$id)->get();
        $estudiantes = DB::table('detalleseccionestudiante')
                        ->join('estudiante','detalleseccionestudiante.idEstudiante','=','estudiante.NIE')
                        ->where('idSeccion','=',$id)->where('estadoeliminacion','=',1)->orderBy('apellidos','asc')->get();
        $profesores = DB::table('detalleseccionmateria')
                        ->join('materia','detalleseccionmateria.idMateria','=','materia.idMateria')
                        ->where('idSeccion','=',$id)->where('idProfesor','=',NULL)->get();
        $profesores2 = DB::table('detalleseccionmateria')
                        ->join('materia','detalleseccionmateria.idMateria','=','materia.idMateria')
                        ->join('profesor','detalleseccionmateria.idProfesor','=','profesor.DUI')
                        ->where('idSeccion','=',$id)->get();
        $estudiantesDisponibles = DB::table('detallegradoestudiante')
                    ->join('estudiante','detallegradoestudiante.idEstudiante','=','estudiante.NIE')
                    ->where('idGrado','=',$seccion[0]->idGrado)->where('detallegradoestudiante.estadoFinalizacion','=',0)
                    ->where('estadoeliminacion','=',1)->whereNotExists(function($subquery) use($id){
                        $subquery
                        ->select('idEstudiante')
                        ->from('detalleseccionestudiante')
                        ->whereColumn('detallegradoestudiante.idEstudiante','detalleseccionestudiante.idEstudiante');
                    })->get();
        return view('secciones.show',compact('id','seccion','estudiantes','profesores','profesores2','estudiantesDisponibles'));
    }

    public function addEstudiantes(Request $request){
        if(!session()->has('administrador')){
            abort('403');
        }

        //validaciones para los campos del formulario
        $validator = Validator::make($request->all(), [
            'seccion' => ['required']
        ]);

        //validaciones para los checkbox
        $validator->after(function($validator) use($request){
            if(!isset($_POST['estudiantes'])){
                $validator->errors()->add('materias','Debe seleccionar 1 o más estudiantes');
            }
        });

        //en caso de existir errores con el ingreso de datos, se detiene la función
        if($validator->fails()){
            return to_route('admin.mostrarSeccion',$request->input('seccion'))->with('errorAgregar','No se han seleccionado estudiantes');
        }

        DB::beginTransaction();
        try{
            foreach($_POST['estudiantes'] as $idEstudiante){
                $detalle = new DetalleSeccionEstudiante();
                $detalle->idSeccion = $request->input('seccion');
                $detalle->idEstudiante = $idEstudiante;
                $detalle->save();
            }
            DB::commit();
                return to_route('admin.mostrarSeccion',$request->input('seccion'))->with('exitoAgregar','Los estudiantes han sido agregado a la sección');
        }
        catch(Exception $e){
            DB::rollback(); 
            return to_route('admin.mostrarSeccion',$request->input('seccion'))->with('errorAgregar','Los estudiantes no han sido agregado a la sección');       
        }
    }

    public function getProfesoresPorMateria(int $id){
        if(!session()->has('administrador')){
            abort('403');
        }
        $profesores = DB::table('detalleseccionmateria')
                    ->join('detalleprofesormateria','detalleseccionmateria.idMateria','=','detalleprofesormateria.idMateria')
                    ->join('profesor','detalleprofesormateria.idProfesor','=','profesor.DUI')
                    ->select('detalleprofesormateria.idProfesor','nombres','apellidos')
                    ->where('detalleseccionmateria.idDetalle','=',$id)->where('estadoeliminacion','=',1)->get();
        return $profesores;
    }

    public function asignarProfesor(Request $request){
        if(!session()->has('administrador')){
            abort('403');
        }
        $validator = Validator::make($request->all(), [
            'detalle' => ['required']
        ]);
        //validaciones extra para elementos select
        $validator->after(function($validator) use($request){
            if($request->input('profesor')==0){
                $validator->errors()->add('profesor','No ha seleccionado profesor');
            }
        });
        //en caso de existir errores con el ingreso de datos, se detiene la función
        if($validator->fails()){
            return to_route('admin.mostrarSeccion',$request->input('seccion2'))->with('errorAsignar','No se ha seleccionado profesor');
        }
        try{
            DB::table('detalleseccionmateria')->where('idDetalle','=',$request->input('detalle'))->update(
                [
                    'idProfesor' => $request->input('profesor'),
                ]
            );
            return to_route('admin.mostrarSeccion',$request->input('seccion2'))->with('exitoAsignar','Se ha asignado el profesor');
        } catch(Exception $e){
            return to_route('admin.mostrarSeccion',$request->input('seccion2'))->with('errorAsignar','Error al asignar profesor');
        }
    }
}
