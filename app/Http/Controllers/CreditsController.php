<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Credits;
use DB, Validator;
class CreditsController extends Controller
{
    /**
     * @param $id
     * @var $data
     * @return $data
     */
    //Listar las materias del estudiante
    public function index($id)
    {
        $data = DB::table('credits')
            ->join(
                'subject_user',
                'credits.subject_user_id',
                '=',
                'subject_user.id'
            )
            ->join('users', 'subject_user.user_id', '=', 'users.id')
            ->join('subjects', 'subject_user.subject_id', '=', 'subjects.id')
            ->select('users.name', 'subjects.name_subjects')
            ->where('semesters_id', $id)
            ->get();

        return response()->json($data);
    }

    /**
     * @param Request $request
     * @var $credits
     * @return $message
     */

    //Crear nuevo
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'semesters' => 'required',
        ]);

        if ($validator->fails()) {
            $message = [
                'tipo' => 'error',
                'mensaje' => $validator->errors(),
            ];
        } else {
            $subject = $request->subject;
            $semesters = $request->semesters;

            if ($this->validateExistence($subject, $semesters)) {
                $credits = new Credits();
                $credits->subject_user_id = $subject;
                $credits->semesters_id = $semesters;
                $credits->save();

                $message = [
                    'tipo' => 'susses',
                    'mensaje' => 'Operación Exitosa',
                ];
            } else {
                $message = [
                    'tipo' => 'error',
                    'mensaje' => 'el usuario no puede repetir la asignatura',
                ];
            }
        }

        return response()->json($message);
    }

    /**
     * @param Request $request
     * @var $credits
     * @return $message
     */

    //Crear nuevo

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'semesters' => 'required',
            'id' => 'require',
        ]);

        if ($validator->fails()) {
            $message = [
                'tipo' => 'error',
                'mensaje' => $validator->errors(),
            ];
        } else {
            $subject = $request->subject;
            $semesters = $request->semesters;

            if ($this->validateExistence($subject, $semesters)) {

                $affected = DB::table('credits')
                    ->where('id', 1)
                    ->update([
                        'subject_user_id' => $subject,
                        'semesters_id' => $semesters,
                    ]);

                $message = [
                    'tipo' => 'susses',
                    'mensaje' => 'Operación Exitosa',
                ];
            } else {
                $message = [
                    'tipo' => 'error',
                    'mensaje' => 'el usuario no puede repetir la asignatura',
                ];
            }
        }

        return response()->json($message);
    }

    /**
     * @param $subject_user_id
     * @param $semesters_id
     * @var $credits
     * @return boolean
     */
    //Validador de materias
    public function validateExistence($subject_user_id, $semesters_id)
    {
        $credits = Credits::select('id')
            ->where('subject_user_id', $subject_user_id)
            ->where('semesters_id', $semesters_id)
            ->first();
        if ($credits != null) {
            return false;
        } else {
            return true;
        }
    }
}
