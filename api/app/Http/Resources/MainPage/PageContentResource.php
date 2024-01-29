<?php

namespace App\Http\Resources\MainPage;

use Illuminate\Http\Resources\Json\JsonResource;

class PageContentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'list_title' => $this->list_title,
            'list' => $this->list,
            'image' => $this->getImage('image'),
        ];
    }
}
