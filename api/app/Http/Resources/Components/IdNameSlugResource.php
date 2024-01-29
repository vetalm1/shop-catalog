<?php

namespace App\Http\Resources\Components;

use Illuminate\Http\Resources\Json\JsonResource;

class IdNameSlugResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
        ];
    }
}
