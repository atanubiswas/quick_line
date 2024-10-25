<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    
    public function user(){
        return $this->belongsTo('App\Models\user')->orderBy("users.name");
    }
    
    public function transaction_by_data(){
        return $this->belongsTo('App\Models\user', 'transaction_by');
    }
}
