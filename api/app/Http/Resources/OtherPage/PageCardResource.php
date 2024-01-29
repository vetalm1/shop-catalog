<?php

namespace App\Http\Resources\OtherPage;

use Illuminate\Http\Resources\Json\JsonResource;

class PageCardResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'title' => $this->title,
            'link' => $this->link,
            'is_big' => $this->is_big,
            'image' => $this->getImage('image'),
        ];
    }
}
