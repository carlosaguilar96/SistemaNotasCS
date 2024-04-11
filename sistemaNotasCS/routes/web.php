<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\GradoController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\ProfesorController;
use App\Models\Profesor;

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
Route::get('/',[LoginController::class, 'welcome'])->name('welcome');
//Ruta para guardar primer administrador
Route::post('/primerAdmin',[LoginController::class, 'guardarPrimerAdmin'])->name('primerAdmin');
//Ruta para realizar login
Route::post('/inicio',[LoginController::class, 'login'])->name('login');
//Ruta para realizar logout
Route::get('/salir',[LoginController::class, 'logout'])->name('logout');

//Rutas relacionadas al sitio del administrador
Route::prefix('admin')->group(function(){
    //Rutas relacionadas al AdminController
    //Ruta para mostrar vista de inicio sitio admin
    Route::get('/inicio',[AdminController::class,'inicio'])->name('admin.inicio');
    //Ruta para mostrar vista de gestión de usuarios
    Route::get('/gestionUsuarios',[AdminController::class,'gestionUsuarios'])->name('admin.gestionUsuarios');
    //Ruta para mostrar vista de gestión de grados
    Route::get('/gestionGrados',[AdminController::class,'gestionGrados'])->name('admin.gestionGrados');

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
    //Ruta para restaurar estudiante
    Route::put('/restaurarEstudiante',[EstudianteController::class,'restore'])->name('admin.restoreEstudiante');

    //Rutas relacionadas a Gestión de Profesores
    //Ruta para mostrar vista para crear profesor
    Route::get('/crearProfesor',[ProfesorController::class,'crearProfesor'])->name('admin.crearProfesor');
    //Ruta para insertar profesor a la bd
    Route::post('/guardarProfesor',[ProfesorController::class,'storeProfesor'])->name('admin.guardarProfesor');
    //Ruta para mostrar vista index
    Route::get('/indexProfesor',[ProfesorController::class,'index'])->name('admin.indexProfesores');
    //Ruta para mostrar profesor
    Route::get('/mostrarProfesor/{id}',[ProfesorController::class,'show'])->name('admin.showProfesor');
    //Ruta para obtener información del profesor
    Route::get('/obtenerInformacionProfesor/{id}',[ProfesorController::class,'getProfesor'])->name('admin.getProfesor');
    //Ruta para agregar materias a profesores en la bd
    Route::post('/agregarMateria',[ProfesorController::class,'agregarDetallePM'])->name('admin.agregarMateria');
    //Ruta para borrar materia que imparte profesor
    Route::delete('/eliminarMateriaProfesor',[ProfesorController::class,'deleteMateria'])->name('admin.deleteMateriaProfesor');
    //Ruta para obtener el detalle de las materias que imparte el profesor
    Route::get('/obtenerDetalleMateria/{id}',[ProfesorController::class,'getProfesorMateria'])->name('admin.getProfesorMateria');
    //Ruta para actualizar información del profesor
    Route::put('/actualizarProfesor',[ProfesorController::class, 'update'])->name('admin.updateProfesor');
    Route::put('/actualizarProfesorFoto',[ProfesorController::class,'updateFoto'])->name('admin.updateProfesorFoto');

    //Rutas relacionadas a Gestión de Administradores
    //Ruta para mostrar vista para crear administrador
    Route::get('/crearAdministrador',[AdminController::class,'creacionAdmin'])->name('admin.crearAdmin');
    //Ruta para insertar administrador a la bd
    Route::post('/guardarAdministrador',[AdminController::class,'storeAdmin'])->name('admin.guardarAdmin');
    //Ruta para mostrar vista index
    Route::get('/indexAdministrador',[AdminController::class,'index'])->name('admin.indexAdministradores');
    //ruta para mostrar administradores
    Route::get('/mostrarAdministrador/{DUI}',[AdminController::class,'show'])->name('admin.showAdministrador');
    //Ruta para obtener información del administrador
    Route::get('/obtenerInformacionAdministrador/{id}',[AdminController::class,'getAdmin'])->name('admin.getAdministrador');
    //Ruta para borrar administrador
    Route::delete('/eliminarAdministrador',[AdminController::class,'delete'])->name('admin.deleteAdministrador');
    //Rutas para actualizar información del administrador
    Route::put('/actualizarAdministrador',[AdminController::class, 'update'])->name('admin.updateAdmin');
    Route::put('/actualizarAdministradorFoto',[AdminController::class,'updateFoto'])->name('admin.updateAdminFoto');
    //Ruta para restaurar administrador
    Route::put('/restaurarAdministrador',[AdminController::class,'restore'])->name('admin.restoreAdmin');

    //Rutas relacionadas a Gestión de Planes Académicos
    //Ruta para mostrar información de grado
    Route::get('/mostrarGrado/{id}',[GradoController::class,'show'])->name('admin.showGrado');
    //Ruta para obtener información de detallegradomateria
    Route::get('/getDetalleGM/{id}',[GradoController::class,'getDetalleGM'])->name('admin.getDetalleGM');
    //Ruta para eliminar materia de plan académico
    Route::delete('/eliminarDetalleGM',[GradoController::class,'eliminarDetalleGM'])->name('admin.deleteDetalleGM');
    //Ruta para agregar materia al plan académico
    Route::post('/agregarDetalleGM',[GradoController::class,'agregarDetalleGM'])->name('admin.addDetalleGM');
    //Ruta para mostrar materias
    Route::get('/indexMaterias',[MateriaController::class,'index'])->name('admin.indexMaterias');
    //Ruta para guardar materia en BD
    Route::post('/guardarMateria',[MateriaController::class,'store'])->name('admin.storeMateria');
    //Ruta para obtener información de materia
    Route::get('/getMateria/{id}',[MateriaController::class,'getMateria'])->name('admin.getMateria');
    //Ruta para actualizar información de materia
    Route::put('/actualizarMateria',[MateriaController::class,'update'])->name('admin.updateMateria');
    //Ruta para eliminar materia
    Route::delete('/eliminarMateria',[MateriaController::class,'delete'])->name('admin.deleteMateria');
    //Ruta para reactivar materia
    Route::put('/reactivarMateria',[MateriaController::class,'restore'])->name('admin.restoreMateria');
});
