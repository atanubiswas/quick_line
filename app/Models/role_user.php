<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class role_user extends Model
{
    use HasFactory;
    
    protected $fillable = ['role_id'];
    public function user(){
        return $this->belongsTo('App\Models\user')->orderBy("users.name");
    }
    
    public function role(){
        return $this->belongsTo('App\Models\role');
    }
}
