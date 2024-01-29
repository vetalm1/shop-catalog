<?php

namespace App\Http\Resources\OtherPage;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TemplatePageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'title' => $this->when($this->title, $this->title),
            'description' => $this->when($this->description, $this->description),
            'seo_title' => $this->seo_title,
            'seo_description' => $this->seo_description,
            'image' => $this->getImageWithoutStub('image'),
        ];
    }
}
