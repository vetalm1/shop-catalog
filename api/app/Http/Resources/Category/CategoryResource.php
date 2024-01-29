<?php

namespace App\Http\Resources\Category;

use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Category */

class CategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'title' => $this->title,
            'description' => $this->description,
            'hidden_description' => $this->hidden_description,
            'card_short_description' => $this->when(!count($this->children), $this->card_short_description),
            'seo_title' => $this->seo_title,
            'seo_description' => $this->seo_description,
        ];
    }
}
