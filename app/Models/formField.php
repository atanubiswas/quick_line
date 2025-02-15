<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class formField extends Model
{
    use HasFactory;
    
    public function formFieldOptions(){
        return $this->hasMany(FormFieldOption::class);
    }
}
