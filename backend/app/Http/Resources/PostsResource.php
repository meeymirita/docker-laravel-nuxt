<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id   ' => $this->user_id,
            'title     ' => $this->title,
            'content   ' => $this->content,
            'likes     ' => $this->likes,
            'views     ' => $this->views,
            'date' => [
                'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
            ]
        ];
    }
}
