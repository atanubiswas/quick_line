<?php
// app/Models/DoctorBill.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoctorBill extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'doctor_id',
        'start_date',
        'end_date',
        'total_amount',
        'total_cases',
        'bill_data',
        'is_paid',
        'paid_by',
        'bill_number', // allow mass assignment
    ];

    protected $casts = [
        'bill_data' => 'array',
        'is_paid' => 'boolean',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function paidBy()
    {
        return $this->belongsTo(User::class, 'paid_by');
    }
}
