<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\ProfesorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//Ruta para mostrar login e inicio de sitio
Route::get('/', function () {
    return view('welcome');
})->name('login');

//Rutas relacionadas al sitio del administrador
Route::prefix('admin')->group(function(){
    Route::post('/inicio',[LoginController::class, 'login'])->name('admin.login');
    //Rutas relacionadas al AdminController
    //Ruta para mostrar vista de inicio sitio admin
    Route::get('/inicio',[AdminController::class,'inicio'])->name('admin.inicio');
    //Ruta para mostrar vista de gestión de usuarios
    Route::get('/gestionUsuarios',[AdminController::class,'gestionUsuarios'])->name('admin.gestionUsuarios');

    //Rutas relacionadas a Gestión de Estudiantes
    //Ruta para mostrar vista para crear estudiante
    Route::get('/crearEstudiante',[EstudianteController::class,'crearEstudiante'])->name('admin.crearEstudiante');
    //Ruta para insertar estudiante a la bd
    Route::post('/guardarEstudiante',[EstudianteController::class,'storeEstudiante'])->name('admin.guardarEstudiante');
    //Ruta para mostrar vista index
    Route::get('/indexEstudiantes',[EstudianteController::class,'index'])->name('admin.indexEstudiantes');
    //Ruta para mostrar estudiante
    Route::get('/mostrarEstudiante/{id}',[EstudianteController::class,'show'])->name('admin.showEstudiante');
    //Ruta para actualizar información del estudiante
    Route::put('/actualizarEstudiante',[EstudianteController::class, 'update'])->name('admin.updateEstudiante');
    Route::put('/actualizarEstudianteFoto',[EstudianteController::class,'updateFoto'])->name('admin.updateEstudianteFoto');
    //Ruta para obtener información del estudiante
    Route::get('/obtenerInformacionEstudiante/{id}',[EstudianteController::class,'getStudent'])->name('admin.getEstudiante');
    //Ruta para borrar estudiante
    Route::delete('/eliminarEstudiante',[EstudianteController::class,'delete'])->name('admin.deleteEstudiante');
    //Ruta para borrar estudiante
    Route::put('/restaurarEstudiante',[EstudianteController::class,'restore'])->name('admin.restoreEstudiante');

    //Rutas relacionadas a Gestión de Profesores
    //Ruta para mostrar vista para crear profesor
    Route::get('/crearProfesor',[ProfesorController::class,'crearProfesor'])->name('admin.crearProfesor');
    //Ruta para insertar profesor a la bd
    Route::post('/guardarProfesor',[ProfesorController::class,'storeProfesor'])->name('admin.guardarProfesor');

    //Rutas relacionadas a Gestión de Administradores
    //Ruta para mostrar vista para crear administrador
    Route::get('/crearAdministrador',[AdminController::class,'creacionAdmin'])->name('admin.crearAdmin');
    //Ruta para insertar administrador a la bd
    Route::post('/guardarAdministrador',[AdminController::class,'storeAdmin'])->name('admin.guardarAdmin');
});
