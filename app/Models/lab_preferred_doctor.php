<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lab_preferred_doctor extends Model
{
    use HasFactory;
    protected $fillable = [
        'laboratorie_id',
        'modality_id',
        'doctor_id',
    ];
}
