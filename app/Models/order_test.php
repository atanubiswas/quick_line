<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_test extends Model
{
    use HasFactory;
    
    public function pathology_tests(){
        return $this->belongsTo('App\Models\PathologyTest', 'pathology_test_id');
    }
}
