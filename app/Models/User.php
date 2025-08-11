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

    // Assigner hasMany caseStudies
    public function assignedCaseStudies() {
        return $this->hasMany(caseStudy::class, 'assigner_id');
    }

    // Quality Controller hasMany caseStudies
    public function qcCaseStudies() {
        return $this->hasMany(caseStudy::class, 'qc_id');
    }

    // Doctor hasMany caseStudies (via Doctor model)
    public function doctorCaseStudies() {
        return $this->hasManyThrough(
            \App\Models\caseStudy::class, // Final model
            \App\Models\Doctor::class,    // Intermediate model
            'user_id',                      // Foreign key on Doctor table
            'doctor_id',                    // Foreign key on caseStudy table
            'id',                           // Local key on User table
            'id'                            // Local key on Doctor table
        )->whereColumn('case_studies.doctor_id', 'doctors.id');
    }

    public function modalities() {
        // return $this->hasMany(qualityControllerModality::class, 'qc_user_id');
        return $this->belongsToMany(
            \App\Models\Modality::class,
            'quality_controller_modalities',
            'qc_user_id',
            'modality_id'
        );
    }
}
