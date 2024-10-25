<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PathologyTest extends Model
{
    use HasFactory;
    
    public function pathlogyTestCategory(){
        return $this->belongsTo('App\Models\PathologyTestCategory', 'pathology_test_categorie_id');
    }
}
