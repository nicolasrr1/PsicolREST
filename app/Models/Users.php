<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'document',
        'name',
        'phone',
        'address',
        'city',
        'rol_id',
        'state',        
    ];

    public $timestamps = false;

    public function rol()
    {
        return $this->belongsTo('App\Models\Rol', 'id');
    }
}
