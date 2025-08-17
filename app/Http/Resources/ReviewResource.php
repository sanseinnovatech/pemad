<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'        => $this->id,
            'user'      => [
                'id'   => $this->user?->id,
                'name' => $this->user?->name,
            ],
            'rating'    => (int) $this->rating,
            'title'     => $this->title,
            'content'   => $this->content,
            'created_at'=> $this->created_at,
        ];
    }
}
