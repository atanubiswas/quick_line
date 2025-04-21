<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class caseStudy extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function study(){
        return $this->hasMany('App\Models\study', 'case_study_id');
    }

    public function images(){
        return $this->hasMany('App\Models\studyImages', 'case_study_id');
    }

    public function status(){
        return $this->belongsTo('App\Models\studyStatus', 'study_status_id');
    }

    public function patient(){
        return $this->belongsTo('App\Models\patient');
    }

    public function laboratory(){
        return $this->belongsTo('App\Models\Laboratory');
    }

    public function doctor(){
        return $this->belongsTo('App\Models\Doctor');
    }

    public function assigner(){
        return $this->belongsTo('App\Models\User', 'assigner_id');
    }

    public function modality(){
        return $this->belongsTo('App\Models\Modality');
    }
}
