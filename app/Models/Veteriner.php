<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veteriner extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_name',
        'clinic_image',
        'register_status',
        'latitude',
        'longitude',
        'address',
        'document',
        'id_user',
        'city',
        'open_time',
        'close_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function queues()
    {
        return $this->hasMany(Queue::class);
    }
}
