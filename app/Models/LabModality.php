<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabModality extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function lab()
    {
        return $this->belongsTo(Laboratory::class);
    }

    public function modality()
    {
        return $this->belongsTo(Modality::class);
    }
}
