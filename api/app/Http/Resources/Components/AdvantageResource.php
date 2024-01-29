<?php

namespace App\Http\Resources\Components;

use App\Models\Advantage;
use Illuminate\Http\Resources\Json\JsonResource;

/**@mixin Advantage*/
class AdvantageResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'sub_title' => $this->sub_title,
            'text' => $this->text,
            'image' => $this->getImage('image'),
            'photo_image' => $this->getImage('photo-image'),
        ];
    }
}
