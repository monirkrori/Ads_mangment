<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'rating'     => $this->rating,
            'stars'      => $this->stars,
            'comment'    => $this->comment,
            'user'       => [
                'id'   => $this->user->id,
                'name' => $this->user->name,
            ],
            'ad_id'      => $this->ad_id,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
