<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorModality extends Model
{
    use HasFactory;
    protected $guarded = [];
    /**
     * Summary of Doctor
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Doctor(){
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Summary of Modality
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Modality(){
        return $this->belongsTo(Modality::class);
    }
}
