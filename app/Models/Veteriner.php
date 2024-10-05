<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veteriner extends Model
{
    use HasFactory;
    protected $fillable = [
        'clinic_name',
        'latitude',
        'latitude',
        'longitude',
        'user_id',
    ];
}