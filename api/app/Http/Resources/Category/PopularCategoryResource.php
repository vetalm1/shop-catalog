<?php

namespace App\Http\Resources\Category;

use App\Http\Resources\Components\IdNameSlugResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PopularCategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'title' => $this->title,
            //'parent_categories' => IdNameSlugResource::collection($this->ancestors()->get()->sortBy('_lft'))
        ];
    }
}
