<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Semesters;
use Validator;
use DB;
class UsersController extends Controller
{
    /**
     * @return json($users)
     */

    public function index()
    {
        try {
            $data = DB::table('users')
            ->join('rol', 'users.rol_id', '=', 'rol.id')
            ->select('users.*', 'rol.rol_name')
            ->get();

            return response()->json($data);

        } catch (\Throwable $th) {
           return $th;
        }

     
    }

    /**
     *  @param $request
     *  @var $users
     *  @var $rol
     *  @var $semester
     *  @return $message
     */

    // Crear usuario
    public function store(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'document' => 'required|unique:users|max:10',
                    'name' => 'required|max:60',
                    'phone' => 'required',
                    'address' => 'required',
                    'city' => 'required',
                    'rol_id' => 'required',
                ],
                [
                    'required' => 'el campo  :attribute es requerido',
                    'unique' => 'el campo :attribute debe ser unico',
                ]
            );

            if ($validator->fails()) {
                $message = [
                    'tipo' => 'error',
                    'mensaje' => $validator->errors(),
                ];
            } else {
                $rol = $request->rol_id;
                $semester = $request->semester;
                $users = new Users();
                $users->document = $request->document;
                $users->name = $request->name;
                $users->phone = $request->phone;
                $users->address = $request->address;
                $users->city = $request->city;
                $users->rol_id = $rol;
                $users->save();

                if ($rol == 1) {
                    $this->semesters($semester, $rol);
                }

                $message = [
                    'tipo' => 'susses',
                    'mensaje' => 'Operación Exitosa',
                ];
            }
            return response()->json($message);
        } catch (Throwable $e) {
            return $e;
        }
    }

    /**
     * @param $semester
     * @param $rol
     * @return null
     **/
    // crear estudiante y semestre
    public function semesters($semester, $rol)
    {
        $semesters = new Semesters();
        $semesters->semester = $semester;
        $semesters->user_id = $this->getId();
        $semesters->save();
    }

    /**
     * @param $users_id
     * @var $users
     * @return $message
     */

    //Inactivar usuario
    public function delete($id)
    {
        try {
            if ($this->validateId($id)) {
                $users = DB::table('users')
                    ->where('id', $id)
                    ->update(['state' => 0]);
                $message = [
                    'tipo' => 'susses',
                    'mensaje' => 'Operación Exitosa',
                ];
            } else {
                $message = [
                    'tipo' => 'error',
                    'mensaje' => 'El usuario no existe ',
                ];
            }

            return response()->json($message);
        } catch (Throwable $e) {
            return $e;
        }
    }

    /**
     * @param $request
     *  @var $users
     *  @var $rol
     *  @var $semester
     * @return message
     */

    //Actualizar usuario
    public function update(Request $request)
    {
        try {
            $id = $request->id;
            if ($this->validateId($id)) {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'document' => 'required|max:10',
                        'name' => 'required|max:60',
                        'phone' => 'required',
                        'address' => 'required',
                        'city' => 'required',
                        'rol_id' => 'required',
                        'id' => 'required',
                    ],
                    [
                        'required' => 'el campo  :attribute es requerido',
                        'unique' => 'el campo :attribute debe ser unico',
                    ]
                );

                if ($validator->fails()) {
                    $message = [
                        'tipo' => 'error',
                        'mensaje' => $validator->errors(),
                    ];
                } else {
                    $rol = $request->rol_id;
                    $semester = $request->semester;

                    $users = DB::table('users')
                        ->where('id', $id)
                        ->update([
                            'document' => $request->document,
                            'name' => $request->name,
                            'phone' => $request->phone,
                            'address' => $request->address,
                            'city' => $request->city,
                            'rol_id' => $rol,
                            'state' => $request->state,
                        ]);
                    if ($rol == 1) {
                        $this->semestersUpdate($semester, $rol);
                    }

                    $message = [
                        'tipo' => 'susses',
                        'mensaje' => 'Operación Exitosa',
                    ];
                }
            } else {
                $message = [
                    'tipo' => 'error',
                    'mensaje' => 'El usuario no existe ',
                ];
            }

            return response()->json($message);
        } catch (Throwable $e) {
            return $e;
        }
    }
    /**
     * @param $id
     * @var $users
     * @return null
     */
    //Actualizar semestre
    public function semestersUpdate($semester, $id)
    {
        if ($this->validateId($id)) {
            $users = DB::table('semesters')
                ->where('user_id', $id)
                ->update(['semester' => $semester]);
        }
    }

    /**
     * @param id
     * @var $users
     * @return boolean
     */

    //validar existencia del id
    public function validateId($id)
    {
        $users = Users::select('id')
            ->where('id', $id)
            ->first();
        if ($users != null) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @var $users_id
     * @return $users_id
     */
    //Obtener el id de usuario
    public function getId()
    {
        $users = Users::select('id')->max('id');
        return $users;
    }
}
