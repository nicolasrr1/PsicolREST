<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credits extends Model
{
    use HasFactory;

    protected $table = 'credits';

    protected $fillable = ['subject_user_id', 'semesters_id'];

    public $timestamps = false;
}
