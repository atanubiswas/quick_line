<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class laboratoryLog extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function users(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function laboratory(){
        return $this->belongsTo('App\Models\Laboratory','laboratorie_id');
    }
}
