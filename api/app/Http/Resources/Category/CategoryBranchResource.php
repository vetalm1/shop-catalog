<?php

namespace App\Http\Resources\Category;

use App\Http\Resources\Components\IdNameSlugResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryBranchResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'children' => IdNameSlugResource::collection($this->children),
        ];
    }
}
