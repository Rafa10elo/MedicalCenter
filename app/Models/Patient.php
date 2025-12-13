<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Patient extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;
    protected $guard_name = 'patient';
    protected $fillable = ['name','email','password','dob','phone'];
    protected $hidden = ['password'];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
