<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class studyType extends Model
{
    use HasFactory;

    public function modality(){
        return $this->belongsTo('App\Models\Modality');
    }

    public function layout(){
        return $this->hasMany('App\Models\modalityStudyLayout')->orderBy("name");
    }

    public function priceGroup()
    {
        return $this->belongsTo(\App\Models\StudyPriceGroup::class, 'price_group_id');
    }
}
