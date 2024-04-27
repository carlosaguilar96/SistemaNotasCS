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

    public function miSeccion(int $id){
        if(!session()->has('profesor')){
            abort('403');
        }
        $seccion = DB::table('secciones')->where('idSeccion','=',$id)->get();
        if(!empty($seccion[0])){
            if($seccion[0]->idSeccion == session()->get('SeccionEncargadoID')){
                $año = DB::table('añoescolar')->where('estadoFinalizacion','=',0)->get();
                $periodo = DB::table('periodos')->where('estado','=',1)->get();
                $totalEstudiantes = DB::table('detalleseccionestudiante')->where('idSeccion','=',$seccion[0]->idSeccion)->count();
                $totalEstudiantesM = DB::table('detalleseccionestudiante')
                                    ->join('estudiante','detalleseccionestudiante.idEstudiante','=','estudiante.NIE')
                                    ->where('idSeccion','=',$seccion[0]->idSeccion)
                                    ->where('sexo','=',1)->count();
                $totalEstudiantesF = DB::table('detalleseccionestudiante')
                                    ->join('estudiante','detalleseccionestudiante.idEstudiante','=','estudiante.NIE')
                                    ->where('idSeccion','=',$seccion[0]->idSeccion)
                                    ->where('sexo','=',2)->count();
                $estudiantes = DB::table('detalleseccionestudiante')
                            ->join('estudiante', 'detalleseccionestudiante.idEstudiante', '=', 'estudiante.NIE')
                            ->where('idSeccion', '=', $seccion[0]->idSeccion)
                            ->orderBy('apellidos','asc')->get();
                $materias = DB::table('detallegradomateria')->join('materia','detallegradomateria.idMateria','=','materia.idMateria')
                            ->where('detallegradomateria.idGrado','=',$seccion[0]->idGrado)->orderBy('materia.nombreMateria','asc')->get();
                $notas=[];
                foreach($estudiantes as $estudiante){
                    $notas1[] = $estudiante->NIE;
                    $i=0;
                    foreach($materias as $materia){
                        $nota = DB::table('nota')->join('detallegradoestudiante', 'nota.idDetalleEstudiante','=','detallegradoestudiante.idDetalle')
                                ->join('estudiante', 'detallegradoestudiante.idEstudiante','=','estudiante.NIE')
                                ->join('detalleseccionmateria','nota.idDetalleMateria','=','detalleseccionmateria.idDetalle')
                                ->join('materia','detalleseccionmateria.idMateria','=','materia.idMateria')
                                ->where('idPeriodo','=',1)
                                ->where('materia.idMateria','=',$materia->idMateria)
                                ->where('detalleseccionmateria.idSeccion','=',$seccion[0]->idSeccion)
                                ->where('NIE','=',$estudiante->NIE)
                                ->select(DB::raw('SUM(porcentajeGanado) as promedio'))
                                ->groupBy('idDetalleEstudiante','idPeriodo','idDetalleMateria')
                                ->orderBy('apellidos','asc')->get();
                        if(isset($nota[0])) $notas1[$estudiante->NIE][$i] = $nota[0]->promedio;
                        else $notas1[$estudiante->NIE][$i] = 0.0;
                        $i++;
                    }
                    $notas2[] = $estudiante->NIE;
                    $i=0;
                    foreach($materias as $materia){
                        $nota = DB::table('nota')->join('detallegradoestudiante', 'nota.idDetalleEstudiante','=','detallegradoestudiante.idDetalle')
                                ->join('estudiante', 'detallegradoestudiante.idEstudiante','=','estudiante.NIE')
                                ->join('detalleseccionmateria','nota.idDetalleMateria','=','detalleseccionmateria.idDetalle')
                                ->join('materia','detalleseccionmateria.idMateria','=','materia.idMateria')
                                ->where('idPeriodo','=',2)
                                ->where('materia.idMateria','=',$materia->idMateria)
                                ->where('detalleseccionmateria.idSeccion','=',$seccion[0]->idSeccion)
                                ->where('NIE','=',$estudiante->NIE)
                                ->select(DB::raw('SUM(porcentajeGanado) as promedio'))
                                ->groupBy('idDetalleEstudiante','idPeriodo','idDetalleMateria')
                                ->orderBy('apellidos','asc')->get();
                        if(isset($nota[0])) $notas2[$estudiante->NIE][$i] = $nota[0]->promedio;
                        else $notas2[$estudiante->NIE][$i] = 0.0;
                        $i++;
                    }
                    $notas3[] = $estudiante->NIE;
                    $i=0;
                    foreach($materias as $materia){
                        $nota = DB::table('nota')->join('detallegradoestudiante', 'nota.idDetalleEstudiante','=','detallegradoestudiante.idDetalle')
                                ->join('estudiante', 'detallegradoestudiante.idEstudiante','=','estudiante.NIE')
                                ->join('detalleseccionmateria','nota.idDetalleMateria','=','detalleseccionmateria.idDetalle')
                                ->join('materia','detalleseccionmateria.idMateria','=','materia.idMateria')
                                ->where('idPeriodo','=',3)
                                ->where('materia.idMateria','=',$materia->idMateria)
                                ->where('detalleseccionmateria.idSeccion','=',$seccion[0]->idSeccion)
                                ->where('NIE','=',$estudiante->NIE)
                                ->select(DB::raw('SUM(porcentajeGanado) as promedio'))
                                ->groupBy('idDetalleEstudiante','idPeriodo','idDetalleMateria')
                                ->orderBy('apellidos','asc')->get();
                        if(isset($nota[0])) $notas3[$estudiante->NIE][$i] = $nota[0]->promedio;
                        else $notas3[$estudiante->NIE][$i] = 0.0;
                        $i++;
                    }
                    $notas4[] = $estudiante->NIE;
                    $i=0;
                    foreach($materias as $materia){
                        $nota = DB::table('nota')->join('detallegradoestudiante', 'nota.idDetalleEstudiante','=','detallegradoestudiante.idDetalle')
                                ->join('estudiante', 'detallegradoestudiante.idEstudiante','=','estudiante.NIE')
                                ->join('detalleseccionmateria','nota.idDetalleMateria','=','detalleseccionmateria.idDetalle')
                                ->join('materia','detalleseccionmateria.idMateria','=','materia.idMateria')
                                ->where('idPeriodo','=',4)
                                ->where('materia.idMateria','=',$materia->idMateria)
                                ->where('detalleseccionmateria.idSeccion','=',$seccion[0]->idSeccion)
                                ->where('NIE','=',$estudiante->NIE)
                                ->select(DB::raw('SUM(porcentajeGanado) as promedio'))
                                ->groupBy('idDetalleEstudiante','idPeriodo','idDetalleMateria')
                                ->orderBy('apellidos','asc')->get();
                        if(isset($nota[0])) $notas4[$estudiante->NIE][$i] = $nota[0]->promedio;
                        else $notas4[$estudiante->NIE][$i] = 0.0;
                        $i++;
                    }
                    $promedios[] = $estudiante->NIE;
                    $i=0;
                    foreach($materias as $materia){
                        $nota = DB::table('nota')->join('detallegradoestudiante', 'nota.idDetalleEstudiante','=','detallegradoestudiante.idDetalle')
                                ->join('estudiante', 'detallegradoestudiante.idEstudiante','=','estudiante.NIE')
                                ->join('detalleseccionmateria','nota.idDetalleMateria','=','detalleseccionmateria.idDetalle')
                                ->join('materia','detalleseccionmateria.idMateria','=','materia.idMateria')
                                ->where('materia.idMateria','=',$materia->idMateria)
                                ->where('detalleseccionmateria.idSeccion','=',$seccion[0]->idSeccion)
                                ->where('NIE','=',$estudiante->NIE)
                                ->select(DB::raw('SUM(porcentajeGanado)/4 as promedio'))
                                ->groupBy('idDetalleEstudiante','idDetalleMateria')
                                ->orderBy('apellidos','asc')->get();
                        if(isset($nota[0])) $promedios[$estudiante->NIE][$i] = $nota[0]->promedio;
                        else $promedios[$estudiante->NIE][$i] = 0.0;
                        $i++;
                    }      
                }
                $promedioFinal = DB::table('nota')->join('detallegradoestudiante', 'nota.idDetalleEstudiante','=','detallegradoestudiante.idDetalle')
                                ->join('estudiante', 'detallegradoestudiante.idEstudiante','=','estudiante.NIE')
                                ->join('detalleseccionmateria','nota.idDetalleMateria','=','detalleseccionmateria.idDetalle')
                                ->join('materia','detalleseccionmateria.idMateria','=','materia.idMateria')
                                ->where('detalleseccionmateria.idSeccion','=',$seccion[0]->idSeccion)
                                ->select(DB::raw('SUM(porcentajeGanado)/16 as promedio'))
                                ->groupBy('idDetalleEstudiante')
                                ->orderBy('apellidos','asc')->get();                              
                return view('secciones.miSeccion',compact('seccion','año','periodo','totalEstudiantes','totalEstudiantesM',
                            'totalEstudiantesF','materias','estudiantes','notas1','notas2','notas3','notas4','promedios','promedioFinal'));
            }
            else{
                abort('403');
            }
        } else{
            abort('404');
        }
    }
}
