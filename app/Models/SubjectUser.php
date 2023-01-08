<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectUser extends Model
{
    use HasFactory;
    protected $table = 'subject_user';

    protected $fillable = ['user_id', 'subject_id'];

        public $timestamps = false;


    public function users(){
        return $this->belongsTo('App\Models\Users','user_id');
    }

    public function subject(){
        return $this->belongsTo('App\Models\Subjects','subject_id');
    }
}



