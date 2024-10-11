<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_name',
        'type',
        'photo',
        'breed',
        'age',
        'weight',
        'id_user',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }

}
