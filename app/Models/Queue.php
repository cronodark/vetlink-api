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
        'id_pet',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'id_customer');
    }

    public function veteriner()
    {
        return $this->belongsTo(Veteriner::class, 'id_veteriner');
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class, 'id_pet');
    }
}
