<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PetTypeResource extends JsonResource
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
            'name' => $this->name,
            'breeds' => $this->breeds ? $this->breeds->map(function ($breed) {
                return [
                    'id' => $breed->id,
                    'breed_name' => $breed->breed_name,
                ];
            }) : [],
        ];
    }
}
