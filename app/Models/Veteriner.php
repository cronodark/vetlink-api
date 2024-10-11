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
        'id_user',
    ];

    public function user(){
        $this->belongsTo(User::class, 'id_user');
    }
}
