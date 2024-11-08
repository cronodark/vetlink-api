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
        'gender',
        'weight',
        'notes',
        'id_user',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }

    public function petType() {
        return $this->belongsTo(PetType::class, 'type', 'id');
    }

    public function petBreed() {
        return $this->belongsTo(PetBreed::class, 'breed', 'id');
    }

    public function queue(){
        return $this->hasMany(Queue::class);
    }
}
