<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class patient extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id',  // Add this line
        'name',
        'age',
        'gender',
        'clinical_history',
    ];
}
