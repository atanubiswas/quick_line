<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'centre_id',
        'start_date',
        'end_date',
        'total_amount',
        'total_study',
        'bill_data',
        'is_paid',
        'invoice_number',
        'paid_by',
        'deleted_by'
    ];

    protected $casts = [
        'bill_data' => 'array',
        'is_paid' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function centre()
    {
        return $this->belongsTo(\App\Models\Laboratory::class, 'centre_id');
    }
    
    public function paidBy()
    {
        return $this->belongsTo(User::class, 'paid_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
