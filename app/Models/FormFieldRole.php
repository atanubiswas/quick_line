<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormFieldRole extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    public function Role(){
        return $this->belongsTo(role::class);
    }
    
    public function FormField(){
        return $this->belongsTo(formField::class);
    }
}
