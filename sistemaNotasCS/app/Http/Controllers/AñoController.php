<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AñoEscolar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AñoController extends Controller
{
    //Función para crear e iniciar nuevo año escolar
    public function store(){
        DB::beginTransaction();
        $año = new AñoEscolar();
        $año->nombreAño = date('Y');
        $año->estadoFinalizacion = 0;
        $año->save();
        DB::commit();
        DB::table('periodos')->where('idPeriodo','=',1)->update(['estado' => 1]);
        return to_route('admin.gestionAño')->with('AñoIniciado','El Año '.$año->nombreAño.' ha sido iniciado\n El periodo I ha comenzado');
    }

    //Función para obtener periodo activo
    public function getPeriodoActivo(){
        $periodo = DB::table('periodos')->where('estado','=',1)->get();
        return $periodo[0];
    }

    //Función para obtener a{o} activo
    public function getAñoActivo(){
        $año = DB::table('añoescolar')->where('estadoFinalizacion','=',0)->get();
        return $año[0];
    }

    //Función para terminar periodo
    public function terminarPeriodo(){
        $periodo = $this->getPeriodoActivo();
        if($periodo->idPeriodo==1){
            DB::table('periodos')->where('idPeriodo','=',2)->update(['estado' => 1]);
            DB::table('periodos')->where('idPeriodo','=',1)->update(['estado' => 0]);
            return to_route('admin.gestionAño')->with('PeriodoFinalizado','El Periodo I ha sido finalizado. El periodo II ha comenzado');
        } else if($periodo->idPeriodo==2){
            DB::table('periodos')->where('idPeriodo','=',3)->update(['estado' => 1]);
            DB::table('periodos')->where('idPeriodo','=',2)->update(['estado' => 0]);
            return to_route('admin.gestionAño')->with('PeriodoFinalizado','El Periodo II ha sido finalizado. El periodo III ha comenzado');
        } else if($periodo->idPeriodo==3){
            DB::table('periodos')->where('idPeriodo','=',4)->update(['estado' => 1]);
            DB::table('periodos')->where('idPeriodo','=',3)->update(['estado' => 0]);
            return to_route('admin.gestionAño')->with('PeriodoFinalizado','El Periodo III ha sido finalizado. El periodo IV ha comenzado');
        } else if($periodo->idPeriodo==4){
            DB::table('periodos')->where('idPeriodo','=',4)->update(['estado' => 0]);
            return to_route('admin.gestionAño')->with('PeriodoFinalizado','El Periodo IV ha sido finalizado. Ahora puede finalizar año');
        } else{
            return to_route('admin.gestionAño')->with('PeriodoNoFinalizado','No hay ciclo por finalizar');
        }
    }

    //Función para terminar año
    public function terminarAño(){
        $año = $this->getAñoActivo();
        DB::table('añoescolar')->where('idAño','=',$año->idAño)->update(['estadoFinalizacion'=>1]);
        return to_route('admin.gestionAño')->with('AñoFinalizado','El año ha sido finalizado');
    }
}
