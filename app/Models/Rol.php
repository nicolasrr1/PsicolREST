<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;


    protected $table = 'rol';

    protected $fillable = [
        'rol_name'
    ];


    public $timestamps = false;


    public function users() {
        return $this->hasMany('App\Models\Users');
    }




}
