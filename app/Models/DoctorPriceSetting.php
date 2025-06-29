<?php
// app/Models/DoctorPriceSetting.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorPriceSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'price_group_id',
        'price',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function priceGroup()
    {
        return $this->belongsTo(StudyPriceGroup::class, 'price_group_id');
    }
}
