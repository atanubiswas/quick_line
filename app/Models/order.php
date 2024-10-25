<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;
    
    public function order_tests(){
        return $this->hasMany('App\Models\order_test');
    }
}
