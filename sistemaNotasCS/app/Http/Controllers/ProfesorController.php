<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class ProfesorController extends Controller
{
    //función para mostrar la vista para crear un profesor
    public function crearProfesor(){
        //se seleccionan de la bd las materias que el docente puede impartir
        $materias = DB::table('materia')->get();
        return view('profesor.crear',compact('materias'));
    }
}