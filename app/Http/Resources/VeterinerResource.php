<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VeterinerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $dataUser = User::find($this->id_user);

        return[
            'id' => $this->id,
            'register_status' => $this->register_status,
            'clinic_name' => $this->clinic_name,
            'clinic_image' => $this->clinic_image,
            'city' => $this->city,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'address' => $this->address,
            'open_time' => $this->open_time,
            'close_time' => $this->close_time,
            'email' => $dataUser->email,
            'phone_number' => $dataUser->phone,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
