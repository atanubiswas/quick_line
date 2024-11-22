<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    public function doctorFormFieldValue(){
        return $this->hasMany('App\Models\docFormFieldValue', 'doctor_id');
    }
    public function DoctorModality(){
        return $this->hasMany(DoctorModality::class)->where("status", '1');
    }
}
