<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class study extends Model
{
    use HasFactory;

    public function images(){
        return $this->hasMany('App\Models\studyImage');
    }

    public function type(){
        return $this->belongsTo('App\Models\studyType', 'study_type_id');
    }
}
