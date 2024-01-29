<?php

namespace App\Support\MediaLibrary;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\ResponsiveImages\ResponsiveImageGenerator;

class GenerateResponsiveImagesJob implements ShouldQueue
{
    /*https://github.com/spatie/laravel-medialibrary/issues/1281*/

    use InteractsWithQueue;
    use Queueable;

    public function __construct(protected Media $media) {}

    public function handle(): bool
    {
        /** @var ResponsiveImageGenerator $responsiveImageGenerator */

        $responsiveImageGenerator = app(ResponsiveImageGenerator::class);
        $responsiveImageGenerator->generateResponsiveImages($this->media);

        return true;
    }
}
