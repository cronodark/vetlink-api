<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VeterinerBasicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'clinic_name' => $this->clinic_name,
            'clinic_image' => $this->clinic_image,
            'city' => $this->city,
            'address' => $this->address,
        ];
    }
}
