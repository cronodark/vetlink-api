<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_time',
        'status',
        'id_customer',
        'id_veteriner',
        'veterinarian_id',
    ];
}
