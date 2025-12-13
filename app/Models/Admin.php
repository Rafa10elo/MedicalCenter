<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;


class Admin extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;
    protected $guard_name = 'admin';
    protected $fillable = ['name','email','password'];
}

