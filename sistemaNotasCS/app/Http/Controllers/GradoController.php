<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DetalleGradoMateria;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GradoController extends Controller
{
    public function show(int $id){
        $informacion = DB::table('grado')
                        ->join('etapa','grado.idEtapa','=','etapa.idEtapa')
                        ->where('idGrado','=',$id)->get();
        $materias = DB::table('detallegradomateria')->join('materia','detallegradomateria.idMateria','=','materia.idMateria')
                        ->where('detallegradomateria.idGrado','=',$id)->get();
        $materiasDisponibles = DB::table('materia')->whereNotExists(function ($subquery) use($id){
                                    $subquery->select('idMateria')
                                    ->from('detallegradomateria')
                                    ->whereColumn('materia.idMateria', 'detallegradomateria.idMateria')
                                    ->where('idGrado','=', $id);
                                })->get();
        return view('grado.show',compact('informacion','materias','materiasDisponibles'));
    }

    public function getDetalleGM(int $id){
        $detalle = DB::table('detallegradomateria')->join('materia','detallegradomateria.idMateria','=','materia.idMateria')
                    ->join('grado','detallegradomateria.idGrado','=','grado.idGrado')
                    ->join('etapa','grado.idEtapa','=','etapa.idEtapa')->where('idDetalle','=',$id)->get();
		return $detalle[0];
    }

    public function eliminarDetalleGM(Request $request){
        try{
            DB::table('detallegradomateria')->where('idDetalle','=',$request->id)->delete();
            return to_route('admin.showGrado',$request->idGrado)->with('ExitoEliminarMateria','La materia ha sido eliminada correctamente.');
        }
        catch(Exception $e){
            return to_route('admin.showGrado',$request->idGrado)->with('ErrorEliminarMateria','La materia no ha sido eliminada correctamente.');
        }
    }

    public function agregarDetalleGM(Request $request){
        $validator = Validator::make($request->all(), [
            'materias' => ['required'],
        ]);
        //validaciones extra para elementos select
        $validator->after(function($validator) use($request){
            if($request->input('materias')==0){
                $validator->errors()->add('materia','No ha seleccionado materia');
            }
        });
        if($validator->fails()){
            return to_route('admin.showGrado',$request->input('idGradoA'))->with('errorAgregarMateria','No ha seleccionado materia para agregar al plan.');
        }
        DB::beginTransaction();
        try{
            $detalle = new DetalleGradoMateria();
            $detalle->idGrado = $request->input('idGradoA');
            $detalle->idMateria = $request->input('materias');
            $detalle->save();
            DB::commit();
            return to_route('admin.showGrado',$request->input('idGradoA'))->with('ExitoAgregarMateria','La materia ha sido agregada correctamente.');
        }
        catch(Exception $e){
            DB::rollback();
            return to_route('admin.showGrado',$request->input('idGradoA'))->with('errorAgregarMateria','La materia no ha sido agregada.');
        }
    }
}
