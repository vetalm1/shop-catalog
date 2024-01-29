<?php

namespace App\Http\Resources\Category;

use App\Http\Resources\Components\IdNameSlugResource;
use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Category */

class CategoryCardResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'card_short_description' => $this->when(!count($this->children), $this->card_short_description),
            'image' => $this->getImage('image'),
            'menu_image' => $this->getImage('menu_image'),
            'children' => IdNameSlugResource::collection($this->children),
        ];
    }
}
