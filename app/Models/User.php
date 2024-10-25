<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\HasApiTokens;
use App\Models\role;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    public function roles(){
        return $this->belongsToMany(role::class, "role_users");
    }

    public function assignRole($role){
        return $this->roles()->sync($role, false);
    }

    public function hasRole($role){
        return $this->roles->contains('name', $role);
    }
    
    public function loginSecurity(){
        return $this->hasOne(LoginSecurity::class);
    }
    
    public function wallet() {
        return $this->hasOne(WalletUser::class);
    }
    
    public function getCollector(){
        return $this->hasOne(Collector::class);
    }
    
    public function getLab(){
        return $this->hasOne(Laboratory::class);
    }
}
