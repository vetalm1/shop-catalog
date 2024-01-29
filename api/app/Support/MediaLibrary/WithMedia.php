<?php

namespace App\Support\MediaLibrary;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;

trait WithMedia
{
   use InteractsWithMedia;

    public function getImage(string $collection, string $conversionName = ''): ?string
    {
        $media = $this->getMedia($collection)->first();

        return !$media
            ? config('app.default_image')
            : $media->getFullUrl($conversionName);
    }

    public function getImages(string $collection, string $conversionName = ''): ?array
    {
        return $this->getMedia($collection)->map(fn ($item) =>  $item->getFullUrl($conversionName))->toArray();
    }

    public function getFile(string $collection): ?array
    {
        $media = $this->getMedia($collection)->first();

        return !$media
            ? null
            : ['url' => $media->getFullUrl(), 'name' => $media->file_name, 'type' => $media->mime_type] ;
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('small')
            ->performOnCollections('image')
            ->width(900);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();
        $this->addMediaCollection('hover_image')->singleFile();
    }
}
