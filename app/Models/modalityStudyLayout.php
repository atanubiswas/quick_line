<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modalityStudyLayout extends Model
{
    use HasFactory;

    public function studyType(){
        return $this->belongsTo(studyType::class, 'study_type_id', 'id');
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class, 'created_by', 'user_id');
    }
}
