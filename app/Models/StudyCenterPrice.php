<?php
// app/Models/StudyCenterPrice.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyCenterPrice extends Model
{
    use HasFactory;

    protected $table = 'study_center_prices';

    protected $fillable = [
        'center_id',
        'study_type_id',
        'price_group_id',
        'price',
    ];

    // Relationships
    public function center()
    {
        return $this->belongsTo(Laboratory::class, 'center_id');
    }

    public function studyType()
    {
        return $this->belongsTo(StudyType::class, 'study_type_id');
    }

    public function priceGroup()
    {
        return $this->belongsTo(StudyPriceGroup::class, 'price_group_id');
    }
}
