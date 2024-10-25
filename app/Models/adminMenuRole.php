<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class adminMenuRole extends Model
{
    use HasFactory;
    
    public function adminMenu(){
        return $this->belongsTo(adminMenu::class);
    }
}
