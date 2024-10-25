<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collector extends Model
{
    use HasFactory;
    
    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function collectorFormFieldValue(){
        return $this->hasMany('App\Models\collectorFormFieldValue', 'collector_id');
    }
}
