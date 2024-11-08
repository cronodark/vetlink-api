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

    public function customer(){
        $this->belongsTo(User::class, 'id_customer');
    }

    public function veteriner(){
        $this->belongsTo(Veteriner::class, 'id_verteriner');
    }

    public function pet(){
        $this->belongsTo(Pet::class, 'id_pet');
    }
}
