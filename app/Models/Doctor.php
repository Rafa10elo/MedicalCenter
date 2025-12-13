<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

class Doctor extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;

    protected $guard_name = 'doctor';
    protected $fillable = ['name','email','password','phone','bio'];
    protected $hidden = ['password','remember_token'];

    public function specialties()
    {
        return $this->belongsToMany(Specialty::class, 'doctor_specialty');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
