<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ForumPostResource extends JsonResource
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
            'status' => $this->status,
            'title' => $this->title,
            'last_seen' => $this->last_seen,
            'characteristics' => $this->characteristics,
            'description' => $this->description,
            'pet_image' => $this->getFullPetImageUrl($this->pet_image),
            'user' => [
                'id' => $this->user->id,
                'username' => $this->user->username,
                'photo' => $this->user->photo,
            ],
            'comments' => ForumCommentResource::collection($this->comments)
        ];
    }

    private function getFullPetImageUrl(string $petImage): string
    {
        // Check if the pet image is already a full URL
        if (filter_var($petImage, FILTER_VALIDATE_URL)) {
            return $petImage;
        }

        // Otherwise, assume it is a path in the storage and generate the full URL
        return url('/storage/' . $this->pet_image);
    }
}
