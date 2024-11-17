<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QueueResource extends JsonResource
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
            'appointment_time' => $this->appointment_time,
            'status' => $this->status,
            'pet' => $this->pet ? [
                'id' => $this->pet->id,
                'name' => $this->pet->pet_name,
                'type' => $this->pet->type,
                'photo' => url('/storage/' . $this->pet->photo)
            ] : null,
            'veteriner' => $this->veteriner ? [
                'id' => $this->veteriner->id,
                'clinic_name' => $this->veteriner->clinic_name,
                'city' => $this->veteriner->city,
            ] : null,
            'customer' => $this->customer ? [
                'id' => $this->customer->id,
                'name' => $this->customer->name,
                'email' => $this->customer->email,
                'phone' => $this->customer->phone,
            ] : null,
        ];
    }
}
