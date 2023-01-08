<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubjectUser;
use Validator, DB;
class SubjectUserController extends Controller
{

    /**
     * @var $data
     * @return $data
     */
    public function index()
    {
        $data = DB::table('subject_user')
            ->join('users', 'subject_user.user_id', '=', 'users.id')
            ->join('subjects', 'subject_user.subject_id', '=', 'subjects.id')
            ->select('users.name','subjects.name_subjects')
            ->get();

            return response()->json($data);
        
    }
    /**
     * @param Request $request
     * @var subjectUser
     * @return message
     */

    //asignar materia profesor
    public function store(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required',
                    'subject_id' => 'required',
                ],
                [
                    'required' => 'el campo  :attribute es requerido',
                ]
            );

            if ($validator->fails()) {
                $message = [
                    'tipo' => 'error',
                    'mensaje' => $validator->errors(),
                ];
            } else {
                $user_id = $request->user_id;
                $subject_id = $request->subject_id;

                if ($this->validateExistence($user_id, $subject_id)) {
                    $subjectUser = new SubjectUser();
                    $subjectUser->user_id = $request->user_id;
                    $subjectUser->subject_id = $request->subject_id;

                    $subjectUser->save();

                    $message = [
                        'tipo' => 'susses',
                        'mensaje' => 'Operación Exitosa',
                    ];
                } else {
                    $message = [
                        'tipo' => 'error',
                        'mensaje' =>
                            'el usuario no puede repetir la asignatura',
                    ];
                }
            }
            return response()->json($message);
        } catch (\Throwable $th) {
            return $th;
        }
    }
    /**
     * @param Request $request
     * @var subjectUser
     * @return message
     */

    //actualizar asignación

    public function update(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required',
                    'subject_id' => 'required',
                    'id' => 'required',
                ],
                [
                    'required' => 'el campo  :attribute es requerido',
                ]
            );
            if ($validator->fails()) {
                $message = [
                    'tipo' => 'error',
                    'mensaje' => $validator->errors(),
                ];
            } else {
                $id = $request->id;

                if ($this->validateId($id)) {
                    $subjectUser = DB::table('subject_user')
                        ->where('id', 1)
                        ->update([
                            'user_id' => $request->user_id,
                            'subject_id' => $request->subject_id,
                        ]);
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
            }

            return response()->json($message);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    //Validar materia profesor

    public function validateExistence($user_id, $subject_id)
    {
        $users = SubjectUser::select('id')
            ->where('user_id', $user_id)
            ->where('subject_id', $subject_id)

            ->first();
        if ($users != null) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @param id
     * @var $subjectUser
     * @return boolean
     */

    //validar existencia del id
    public function validateId($id)
    {
        $users = SubjectUser::select('id')
            ->where('id', $id)
            ->first();
        if ($users != null) {
            return true;
        } else {
            return false;
        }
    }
}
