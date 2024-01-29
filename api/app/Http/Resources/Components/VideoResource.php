<?php

namespace App\Http\Resources\Components;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'button_text' => $this->button_text,
            'link' => $this->link,
            'image' => $this->getImage('image'),
            'file' => $this->getFile('video-file'),
        ];
    }
}
