<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'user_name' => $this->user_name,
            'image_url' => $this->getImageURL(),
            'bio' => $this->bio,
            'is_admin' => (bool) $this->is_admin,
            'joined_at' => $this->created_at,
            // Use whenCounted to include counts only when they are loaded
            'stats' => [
                'ideas_count' => $this->whenCounted('ideas'),
                'comments_count' => $this->whenCounted('comments'),
                'likes_count' => $this->whenCounted('likes'),
                'followers_count' => $this->whenCounted('followers'),
                'followings_count' => $this->whenCounted('followings'),
            ],
            // Conditionally include the user's ideas only when the relationship is loaded
            'ideas' => IdeaResource::collection($this->whenLoaded('ideas')),
        ];
    }
}
