<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function breeds(){
        return $this->hasMany(PetBreed::class, 'pet_type_id');
    }
}
