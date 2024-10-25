<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectorLabAssociation extends Model
{
    use HasFactory;
    
    public function collector(){
        return $this->belongsTo(Collector::class);
    }
}
