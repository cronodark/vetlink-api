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
            'clinic_image' => $this->getFullVetImageUrl($this->clinic_image),
            'document' => $this->url($this->documenturl),
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

    private function getFullVetImageUrl(string $clinic_image): string
    {
        // Check if the pet image is already a full URL
        if (filter_var($clinic_image, FILTER_VALIDATE_URL)) {
            return $clinic_image;
        }

        // Otherwise, assume it is a path in the storage and generate the full URL
        return url('/storage/' . $this->clinic_image);
    }

    public function url($path)
    {
        return url('/storage/' . $this->document);
    }
}
