<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subjects;
use Validator;
use DB;
class SubjectsController extends Controller
{
    /**
     * @return $subjects
     */

    //Lista de asignaturas
    public function index()
    {
        try {
            $subjects = Subjects::all();
            return response()->json($subjects);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * @param Request
     * @var $subject
     * @return message
     */

    //Crear asignaturas
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name_subjects' => 'required',
                'desciption' => 'required',
                'knowledge' => 'required',
                'mandatory' => 'required',
            ]);

            if ($validator->fails()) {
                $message = [
                    'tipo' => 'error',
                    'mensaje' => $validator->errors(),
                ];
            } else {
                $subjects = new Subjects();
                $subjects->name_subjects = $request->name_subjects;
                $subjects->desciption = $request->desciption;
                $subjects->knowledge = $request->knowledge;
                $subjects->mandatory = $request->mandatory;
                $subjects->save();

                $message = [
                    'tipo' => 'susses',
                    'mensaje' => 'Operación Exitosa',
                ];
            }
            return response()->json($message);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * @param $id
     * @return message
     */
    // Cambiar estado
    public function delete($id)
    {
        try {
            if ($this->validateId($id)) {
                DB::table('subjects')
                    ->where('id', $id)
                    ->update(['state' => 0]);
                $message = [
                    'tipo' => 'susses',
                    'mensaje' => 'Operación Exitosa',
                ];
            } else {
                $message = [
                    'tipo' => 'error',
                    'mensaje' => 'El dato no existe actualmente',
                ];
            }
            return response()->json($message);
        } catch (\Throwable $th) {
            return $th;
        }
    }
    /**
     * @param Request
     * @var $subjects
     * @return message
     */
    //Actualizar asignaturas
    public function update( Request $request)
    {
        $id = $request->id;

        if ($this->validateId($id)) {
            $validator = Validator::make($request->all(), [
                'name_subjects' => 'required',
                'desciption' => 'required',
                'knowledge' => 'required',
                'mandatory' => 'required',
                'id' => 'required',
            ]);

            if ($validator->fails()) {
                $message = [
                    'tipo' => 'error',
                    'mensaje' => $validator->errors(),
                ];
            } else {
                $subjects = DB::table('subjects')
                    ->where('id', $id)
                    ->update([
                        'name_subjects' => $request->name_subjects,
                        'desciption' => $request->desciption,
                        'knowledge' => $request->knowledge,
                        'mandatory' => $request->mandatory,
                        'state' => $request->state,
                    ]);
                $message = [
                    'tipo' => 'susses',
                    'mensaje' => 'Operación Exitosa',
                ];
            }
            return response()->json($message);
        } else {
            $message = [
                'tipo' => 'error',
                'mensaje' => 'El dato no existe actualmente',
            ];
        }
    }

    /**
     * @param $id
     * @return boolean
     */
    //validar id existente
    public function validateId($id)
    {
        $subjects = Subjects::select('id')
            ->where('id', $id)
            ->first();
        if ($subjects != null) {
            return true;
        } else {
            return false;
        }
    }
}
