<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

class Doctor extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles, SoftDeletes;
    protected $guard_name = 'sanctum';
    protected $fillable = ['name','email','password','phone','bio'];
    protected $hidden = ['password','remember_token'];
    protected $casts = [
        'password' => 'hashed',
    ];

    public function specialties()
    {
        return $this->belongsToMany(Specialty::class, 'doctor_specialty');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
