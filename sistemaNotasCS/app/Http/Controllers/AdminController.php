<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
    //función para mostrar la vista de inicio del sitio administrador
    public function inicio(){
        return view('sitioAdmin.inicio');
    }

    //función para mostrar la vista de gestión de usuarios
    public function gestionUsuarios(){
        return view('sitioAdmin.gestionUsuarios');
    }
}