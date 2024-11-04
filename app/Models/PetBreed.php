<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetBreed extends Model
{
    use HasFactory;

    protected $fillable = [
        'breed_name',
        'pet_type_id',
    ];

    public function petType(){
        return $this->belongsTo(PetType::class, 'pet_type_id', 'id');
    }
}
