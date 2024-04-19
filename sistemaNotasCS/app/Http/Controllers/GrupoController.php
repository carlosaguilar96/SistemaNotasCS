<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
                                    
                return view('grupos.show',compact('grupo','año','periodo','totalEstudiantes','totalEstudiantesM','totalEstudiantesF'));
            } else{
                abort('403');
            }
        }
        else{
            abort('404');
        }
    }
}
