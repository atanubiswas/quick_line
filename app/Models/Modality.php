<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modality extends Model
{
    use HasFactory;

    public function DoctorModality(){
        return $this->hasMany(DoctorModality::class, 'modality_id')->where("status", '1');
    }

    public function doctors(){
        return $this->belongsToMany(Doctor::class, 'doctor_modalities');
    }
}
