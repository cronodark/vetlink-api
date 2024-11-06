<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'pet_name' => $this->pet_name,
            'photo' => url('/storage/' . $this->photo),
            'type' => $this->petType->name,
            'breed' => $this->petBreed->breed_name,
            'gender' => $this->gender,
            'age' => $this->age,
            'weight' => $this->weight,
            'notes' => $this->notes,
        ];
    }
}
