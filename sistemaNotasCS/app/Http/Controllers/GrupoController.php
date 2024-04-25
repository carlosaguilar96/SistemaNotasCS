<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Notas;
use Carbon\Exceptions\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GrupoController extends Controller
{
    //ruta para mostrar grupo
    public function show(int $id){
        //verificando que la sesión sea de un usuario profesor
        if(!session()->has('profesor')){
            abort('403');
        }
        $grupo = DB::table('detalleseccionmateria')
                ->join('secciones','detalleseccionmateria.idSeccion','=','secciones.idSeccion')
                ->join('materia','detalleseccionmateria.idMateria','=','materia.idMateria')
                ->where('idDetalle','=',$id)->get();
        //verificando que el grupo exista
        if(!empty($grupo[0])){
            //verificando que el grupo pertenezca al profesor
            if(in_array($grupo[0]->idDetalle,session()->get('ArregloGrupos'))){
                $año = DB::table('añoescolar')->where('estadoFinalizacion','=',0)->get();
                $periodo = DB::table('periodos')->where('estado','=',1)->get();
                $totalEstudiantes = DB::table('detalleseccionestudiante')->where('idSeccion','=',$grupo[0]->idSeccion)->count();
                $totalEstudiantesM = DB::table('detalleseccionestudiante')
                                    ->join('estudiante','detalleseccionestudiante.idEstudiante','=','estudiante.NIE')
                                    ->where('idSeccion','=',$grupo[0]->idSeccion)
                                    ->where('sexo','=',1)->count();
                $totalEstudiantesF = DB::table('detalleseccionestudiante')
                                    ->join('estudiante','detalleseccionestudiante.idEstudiante','=','estudiante.NIE')
                                    ->where('idSeccion','=',$grupo[0]->idSeccion)
                                    ->where('sexo','=',2)->count();
                $verificarEvaluacion1 = DB::table('nota')->where('idEvaluacion','=',1)
                                                         ->where('idDetalleMateria','=',$grupo[0]->idDetalle)
                                                         ->where('idPeriodo','=',$periodo[0]->idPeriodo)
                                                         ->count();
                $verificarEvaluacion2 = DB::table('nota')->where('idEvaluacion','=',2)
                                                         ->where('idDetalleMateria','=',$grupo[0]->idDetalle)
                                                         ->where('idPeriodo','=',$periodo[0]->idPeriodo)
                                                         ->count();
                $verificarEvaluacion3 = DB::table('nota')->where('idEvaluacion','=',3)
                                                         ->where('idDetalleMateria','=',$grupo[0]->idDetalle)
                                                         ->where('idPeriodo','=',$periodo[0]->idPeriodo)
                                                         ->count();
                $verificarEvaluacion4 = DB::table('nota')->where('idEvaluacion','=',4)
                                                         ->where('idDetalleMateria','=',$grupo[0]->idDetalle)
                                                         ->where('idPeriodo','=',$periodo[0]->idPeriodo)
                                                         ->count();
                $verificarEvaluacion5 = DB::table('nota')->where('idEvaluacion','=',5)
                                                         ->where('idDetalleMateria','=',$grupo[0]->idDetalle)
                                                         ->where('idPeriodo','=',$periodo[0]->idPeriodo)
                                                         ->count();
                $estudiantes = DB::table('detalleseccionestudiante')
                            ->join('estudiante', 'detalleseccionestudiante.idEstudiante', '=', 'estudiante.NIE')
                            ->where('idSeccion', '=', $grupo[0]->idSeccion)
                            ->orderBy('apellidos','asc')->get();
                $notas11 = DB::table('nota')->join('detallegradoestudiante', 'nota.idDetalleEstudiante','=','detallegradoestudiante.idDetalle')
                               ->join('estudiante', 'detallegradoestudiante.idEstudiante','=','estudiante.NIE')
                               ->where('idEvaluacion','=',1)
                               ->where('idDetalleMateria','=',$id)
                               ->where('idPeriodo','=',1)
                               ->orderBy('apellidos','asc')->get();
                $notas12 = DB::table('nota')->join('detallegradoestudiante', 'nota.idDetalleEstudiante','=','detallegradoestudiante.idDetalle')
                                ->join('estudiante', 'detallegradoestudiante.idEstudiante','=','estudiante.NIE')
                                ->where('idEvaluacion','=',2)
                                ->where('idDetalleMateria','=',$id)
                                ->where('idPeriodo','=',1)
                                ->orderBy('apellidos','asc')->get();
                $notas13 = DB::table('nota')->join('detallegradoestudiante', 'nota.idDetalleEstudiante','=','detallegradoestudiante.idDetalle')
                               ->join('estudiante', 'detallegradoestudiante.idEstudiante','=','estudiante.NIE')
                               ->where('idEvaluacion','=',3)
                               ->where('idDetalleMateria','=',$id)
                               ->where('idPeriodo','=',1)
                               ->orderBy('apellidos','asc')->get();
                $notas14 = DB::table('nota')->join('detallegradoestudiante', 'nota.idDetalleEstudiante','=','detallegradoestudiante.idDetalle')
                               ->join('estudiante', 'detallegradoestudiante.idEstudiante','=','estudiante.NIE')
                               ->where('idEvaluacion','=',4)
                               ->where('idDetalleMateria','=',$id)
                               ->where('idPeriodo','=',1)
                               ->orderBy('apellidos','asc')->get();
                $notas15 = DB::table('nota')->join('detallegradoestudiante', 'nota.idDetalleEstudiante','=','detallegradoestudiante.idDetalle')
                               ->join('estudiante', 'detallegradoestudiante.idEstudiante','=','estudiante.NIE')
                               ->where('idEvaluacion','=',5)
                               ->where('idDetalleMateria','=',$id)
                               ->where('idPeriodo','=',1)
                               ->orderBy('apellidos','asc')->get();
                $notas21 = DB::table('nota')->join('detallegradoestudiante', 'nota.idDetalleEstudiante','=','detallegradoestudiante.idDetalle')
                               ->join('estudiante', 'detallegradoestudiante.idEstudiante','=','estudiante.NIE')
                               ->where('idEvaluacion','=',1)
                               ->where('idDetalleMateria','=',$id)
                               ->where('idPeriodo','=',2)
                               ->orderBy('apellidos','asc')->get();
                $notas22 = DB::table('nota')->join('detallegradoestudiante', 'nota.idDetalleEstudiante','=','detallegradoestudiante.idDetalle')
                                ->join('estudiante', 'detallegradoestudiante.idEstudiante','=','estudiante.NIE')
                                ->where('idEvaluacion','=',2)
                                ->where('idDetalleMateria','=',$id)
                                ->where('idPeriodo','=',2)
                                ->orderBy('apellidos','asc')->get();
                $notas23 = DB::table('nota')->join('detallegradoestudiante', 'nota.idDetalleEstudiante','=','detallegradoestudiante.idDetalle')
                               ->join('estudiante', 'detallegradoestudiante.idEstudiante','=','estudiante.NIE')
                               ->where('idEvaluacion','=',3)
                               ->where('idDetalleMateria','=',$id)
                               ->where('idPeriodo','=',2)
                               ->orderBy('apellidos','asc')->get();
                $notas24 = DB::table('nota')->join('detallegradoestudiante', 'nota.idDetalleEstudiante','=','detallegradoestudiante.idDetalle')
                               ->join('estudiante', 'detallegradoestudiante.idEstudiante','=','estudiante.NIE')
                               ->where('idEvaluacion','=',4)
                               ->where('idDetalleMateria','=',$id)
                               ->where('idPeriodo','=',2)
                               ->orderBy('apellidos','asc')->get();
                $notas25 = DB::table('nota')->join('detallegradoestudiante', 'nota.idDetalleEstudiante','=','detallegradoestudiante.idDetalle')
                               ->join('estudiante', 'detallegradoestudiante.idEstudiante','=','estudiante.NIE')
                               ->where('idEvaluacion','=',5)
                               ->where('idDetalleMateria','=',$id)
                               ->where('idPeriodo','=',2)
                               ->orderBy('apellidos','asc')->get();  
                $notas31 = DB::table('nota')->join('detallegradoestudiante', 'nota.idDetalleEstudiante','=','detallegradoestudiante.idDetalle')
                               ->join('estudiante', 'detallegradoestudiante.idEstudiante','=','estudiante.NIE')
                               ->where('idEvaluacion','=',1)
                               ->where('idDetalleMateria','=',$id)
                               ->where('idPeriodo','=',3)
                               ->orderBy('apellidos','asc')->get();
                $notas32 = DB::table('nota')->join('detallegradoestudiante', 'nota.idDetalleEstudiante','=','detallegradoestudiante.idDetalle')
                                ->join('estudiante', 'detallegradoestudiante.idEstudiante','=','estudiante.NIE')
                                ->where('idEvaluacion','=',2)
                                ->where('idDetalleMateria','=',$id)
                                ->where('idPeriodo','=',3)
                                ->orderBy('apellidos','asc')->get();
                $notas33 = DB::table('nota')->join('detallegradoestudiante', 'nota.idDetalleEstudiante','=','detallegradoestudiante.idDetalle')
                               ->join('estudiante', 'detallegradoestudiante.idEstudiante','=','estudiante.NIE')
                               ->where('idEvaluacion','=',3)
                               ->where('idDetalleMateria','=',$id)
                               ->where('idPeriodo','=',3)
                               ->orderBy('apellidos','asc')->get();
                $notas34 = DB::table('nota')->join('detallegradoestudiante', 'nota.idDetalleEstudiante','=','detallegradoestudiante.idDetalle')
                               ->join('estudiante', 'detallegradoestudiante.idEstudiante','=','estudiante.NIE')
                               ->where('idEvaluacion','=',4)
                               ->where('idDetalleMateria','=',$id)
                               ->where('idPeriodo','=',3)
                               ->orderBy('apellidos','asc')->get();
                $notas35 = DB::table('nota')->join('detallegradoestudiante', 'nota.idDetalleEstudiante','=','detallegradoestudiante.idDetalle')
                               ->join('estudiante', 'detallegradoestudiante.idEstudiante','=','estudiante.NIE')
                               ->where('idEvaluacion','=',5)
                               ->where('idDetalleMateria','=',$id)
                               ->where('idPeriodo','=',3)
                               ->orderBy('apellidos','asc')->get();
                $notas41 = DB::table('nota')->join('detallegradoestudiante', 'nota.idDetalleEstudiante','=','detallegradoestudiante.idDetalle')
                               ->join('estudiante', 'detallegradoestudiante.idEstudiante','=','estudiante.NIE')
                               ->where('idEvaluacion','=',1)
                               ->where('idDetalleMateria','=',$id)
                               ->where('idPeriodo','=',4)
                               ->orderBy('apellidos','asc')->get();
                $notas42 = DB::table('nota')->join('detallegradoestudiante', 'nota.idDetalleEstudiante','=','detallegradoestudiante.idDetalle')
                                ->join('estudiante', 'detallegradoestudiante.idEstudiante','=','estudiante.NIE')
                                ->where('idEvaluacion','=',2)
                                ->where('idDetalleMateria','=',$id)
                                ->where('idPeriodo','=',4)
                                ->orderBy('apellidos','asc')->get();
                $notas43 = DB::table('nota')->join('detallegradoestudiante', 'nota.idDetalleEstudiante','=','detallegradoestudiante.idDetalle')
                               ->join('estudiante', 'detallegradoestudiante.idEstudiante','=','estudiante.NIE')
                               ->where('idEvaluacion','=',3)
                               ->where('idDetalleMateria','=',$id)
                               ->where('idPeriodo','=',4)
                               ->orderBy('apellidos','asc')->get();
                $notas44 = DB::table('nota')->join('detallegradoestudiante', 'nota.idDetalleEstudiante','=','detallegradoestudiante.idDetalle')
                               ->join('estudiante', 'detallegradoestudiante.idEstudiante','=','estudiante.NIE')
                               ->where('idEvaluacion','=',4)
                               ->where('idDetalleMateria','=',$id)
                               ->where('idPeriodo','=',4)
                               ->orderBy('apellidos','asc')->get();
                $notas45 = DB::table('nota')->join('detallegradoestudiante', 'nota.idDetalleEstudiante','=','detallegradoestudiante.idDetalle')
                               ->join('estudiante', 'detallegradoestudiante.idEstudiante','=','estudiante.NIE')
                               ->where('idEvaluacion','=',5)
                               ->where('idDetalleMateria','=',$id)
                               ->where('idPeriodo','=',4)
                               ->orderBy('apellidos','asc')->get();                                                                                                                
                                    
                return view('grupos.show',compact('grupo','año','periodo','totalEstudiantes','totalEstudiantesM',
                'totalEstudiantesF','verificarEvaluacion1','verificarEvaluacion2','verificarEvaluacion3',
                'verificarEvaluacion4','verificarEvaluacion5','estudiantes','notas11', 'notas12', 'notas13', 'notas14', 'notas15',
                'notas21', 'notas22', 'notas23', 'notas24', 'notas25', 'notas31', 'notas32', 'notas33', 'notas34', 'notas35',
                'notas41', 'notas42', 'notas43', 'notas44', 'notas45'));
            } else{
                abort('403');
            }
        }
        else{
            abort('404');
        }
    }

    public function agregarNotas(int $evaluacion, int $idgrupo)
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
                $totalEstudiantes = DB::table('detalleseccionestudiante')->where('idSeccion', '=', $grupo[0]->idSeccion)->count();
                $estudiantes = DB::table('detalleseccionestudiante')
                    ->join('estudiante', 'detalleseccionestudiante.idEstudiante', '=', 'estudiante.NIE')
                    ->where('idSeccion', '=', $grupo[0]->idSeccion)
                    ->orderBy('apellidos','asc')->get();
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
                $porcentaje = DB::table('evaluacion')->select('porcentaje')->where('idEvaluacion','=',$detalle->idEvaluacion)->get();
                $detalle->porcentajeGanado = $nota * $porcentaje[0]->porcentaje / 100;
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
                                           ->where('idPeriodo','=',$periodo[0]->idPeriodo)
                                           ->orderBy('apellidos','asc')->get();
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
            $request->validate([
                'nota' => ['required', 'numeric', 'min:0', 'max:10']
            ]);
            $idNota = $request->input('notaA');
            $nota = $request->input('nota');
            $porcentaje = DB::table('evaluacion')->select('porcentaje')->where('idEvaluacion','=',$request->input('evaluacion'))->get();
            $porcentajeGanado = $nota * $porcentaje[0]->porcentaje / 100;
            DB::table('nota')->where('idNota', '=', $idNota)->update(
                [
                    'nota' => $nota,
                    'porcentajeGanado' => $porcentajeGanado,
                ]
            );
            return to_route('profesor.mostrarNotas', [$request->input('evaluacion'), $request->input('grupo')])->with('exitoModificarNotas', 'La nota ha sido modificada exitosamente');
        }catch(Exception $e){
            return to_route('profesor.mostrarNotas', [$request->input('evaluacion'), $request->input('grupo')])->with('errorModificarNotas', 'La nota no ha sido modificada exitosamente');
        }
    }

    public function getNota(int $id)
    {
        if (!session()->has('profesor')) {
            abort('403');
        }

        $nota = Notas::find($id);
        if(!isset($nota)) abort('404');
        else return $nota;
    }
}
