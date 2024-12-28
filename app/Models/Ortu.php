<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Ortu extends Authenticatable
{
    use HasFactory;
    protected $guard = 'ortu';
    protected $fillable = [
        'name',
        'username',
        'password',
        'no_hp',
        'alamat',
        'nis_anak',
    ];
}