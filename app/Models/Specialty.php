<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class Specialty extends Model
{
    use HasTranslations, SoftDeletes;

    public $translatable = ['name'];

    protected $fillable = ['name'];
}
