<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Materia;
use Carbon\Exceptions\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MateriaController extends Controller
{
    //función para mostrar vista con listado de materias
    public function index(){
        $materias = DB::table('materia')->where('estadoeliminacion','=',0)->get();
        $materiasEliminadas = DB::table('materia')->where('estadoeliminacion','=',1)->get();
        return view('materias.index',compact('materias','materiasEliminadas'));
    }

    //función para almacenar una materia en bd
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'materia' => ['required'],
        ]);
        if($validator->fails()){
            return to_route('admin.indexMaterias')->with('errorAgregarMateria','El campo nombre es requerido para ingresar materia.');
        }

        DB::beginTransaction();
        try{
            $materia = new Materia();
            $materia->nombreMateria = $request->input('materia');
            $materia->estadoeliminacion = 0;
            $materia->save();
            DB::commit();
            return to_route('admin.indexMaterias')->with('exitoAgregarMateria','La materia ha sido registrada exitosamente.');
        }
        catch(Exception $e){
            DB::rollback();
            return to_route('admin.indexMaterias')->with('errorAgregarMateria','Error al agregar materia.');
        }
    }

    //función para obtener información de materia
    public function getMateria(int $id){
        $materia = Materia::find($id);
		return $materia;
    }

    //función para actualizar información de materia
    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'nombreU' => ['required'],
        ]);
        if($validator->fails()){
            return to_route('admin.indexMaterias')->with('errorModificarMateria','El campo nombre es requerido para ingresar materia.');
        }

        try{
            DB::table('materia')->where('idMateria','=',$request->input('idU'))->update(
                [
                    'nombreMateria' => $request->nombreU,
                ]
            );
            return to_route('admin.indexMaterias')->with('exitoModificarMateria','El nombre de la materia ha sido modificado exitosamente.');
        }
        catch(Exception $e){
            return to_route('admin.indexMaterias')->with('errorModificarMateria','Error al modificar materia.');
        }
    }

    //función para eliminar materia
    public function delete(Request $request){
        try{
            DB::table('materia')->where('idMateria','=',$request->input('idE'))->update(
                [
                    'estadoeliminacion' => 1,
                ]
            );
            return to_route('admin.indexMaterias')->with('exitoEliminarMateria','La materia ha sido eliminada exitosamente.');
        }
        catch(Exception $e){
            return to_route('admin.indexMaterias')->with('errorEliminarMateria','Error al eliminar materia.');
        }
    }

    //función para reactivar materia
    public function restore(Request $request){
        try{
            DB::table('materia')->where('idMateria','=',$request->input('idR'))->update(
                [
                    'estadoeliminacion' => 0,
                ]
            );
            return to_route('admin.indexMaterias')->with('exitoRestoreMateria','La materia ha sido reactivada exitosamente.');
        }
        catch(Exception $e){
            return to_route('admin.indexMaterias')->with('errorRestoreMateria','Error al reactivar materia.');
        }
    }
}
