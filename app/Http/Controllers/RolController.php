<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rol;
class RolController extends Controller
{
    /**
     * @return rol
     */

     // lista de roles 
    public function index(){
        $rol = Rol::all();
    }
}
