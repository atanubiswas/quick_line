<?php
// app/Models/StudyPriceGroup.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyPriceGroup extends Model
{
    use HasFactory;

    protected $table = 'study_price_group';

    protected $fillable = [
        'name',
        'default_price',
    ];

    // Relationships
    public function studyTypes()
    {
        return $this->hasMany(StudyType::class, 'price_group_id');
    }
}
