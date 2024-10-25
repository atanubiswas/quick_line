<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class doctor extends Model
{
    use HasFactory;
    
    public function docFormFieldValue(){
        return $this->hasMany('App\Models\docFormFieldValue', 'doctor_id');
    }
}
