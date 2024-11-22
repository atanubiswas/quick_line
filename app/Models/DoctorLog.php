<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorLog extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function users(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function doctor(){
        return $this->belongsTo('App\Models\Doctor','doctor_id');
    }
}
