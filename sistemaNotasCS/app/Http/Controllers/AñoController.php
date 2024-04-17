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
        return to_route('admin.gestionAño')->with('AñoIniciado','El Año '.$año->nombreAño.' ha sido iniciado.');
    }

    //Función para obtener periodo activo
    public function getPeriodoActivo(){
        $periodo = DB::table('periodos')->where('estado','=',1)->get();
        return $periodo[0];
    }

    //Función para terminar periodo
    public function terminarPeriodo(){

    }
}
