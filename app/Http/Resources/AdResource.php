<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'title'       => ucfirst($this->title),
            'description' => $this->description,
            'price'       => $this->formatted_price,
            'status'      => $this->status,
            'user'        => [
                'id'    => $this->user->id,
                'name'  => $this->user->name,
                'email' => $this->user->email,
            ],
            'category' => [
                'id'   => $this->category->id,
                'name' => $this->category->name,
            ],
            'images'         => $this->images->pluck('path'),
            'reviews_count'  => $this->reviews_count ?? $this->reviews()->count(),
            'created_at'     => $this->created_at->toDateTimeString(),
        ];
    }
}
