<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class adminMenu extends Model
{
    use HasFactory;
    
    public function children(){
        return $this->hasMany(adminMenu::class, 'parent_id');
    }
}
