<?php

namespace App\Http\Controllers;

class ProfesorController extends Controller
{
    public function crearProfesor(){
        return view('profesor.crear');
    }
}