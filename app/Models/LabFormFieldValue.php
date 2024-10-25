<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabFormFieldValue extends Model
{
    use HasFactory;
    
    public function formField(){
        return $this->belongsTo('App\Models\formField');
    }
}
