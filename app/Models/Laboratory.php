<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laboratory extends Model
{
    use HasFactory;
    
    public function labFormFieldValue(){
        return $this->hasMany('App\Models\LabFormFieldValue', 'laboratorie_id');
    }
    
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function labModality(){
        return $this->hasMany(LabModality::class);
    }
}
