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
            'title' => $this->title,
            'last_seen' => $this->last_seen,
            'characteristics' => $this->characteristics,
            'description' => $this->description,
            'pet_image' => $this->pet_image,
            'user' => [
                'id' => $this->user->id,
                'username' => $this->user->name,
                'photo' => $this->user->photo,
            ],
            'comments' => ForumCommentResource::collection($this->comments)
        ];
    }
}
