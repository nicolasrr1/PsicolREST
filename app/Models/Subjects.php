<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subjects extends Model
{
    use HasFactory;
    protected $table = 'subjects';

    protected $fillable = [
        'name_subjects',
        'desciption',
        'knowledge',
        'mandatory',
        'state',
    ];

    public $timestamps = false;
}
