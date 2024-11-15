<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'forum_post_id' => $this->forum_post_id,
            'user' => [
                'id' => $this->user_id,
                'name' => $this->user->name,
                'username' => $this->user->username,
                'photo' => $this->user->photo,
            ],
            'content' => $this->content,
        ];
    }
}
