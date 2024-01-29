<?php

namespace App\Support\MediaLibrary;

use Illuminate\Bus\Queueable;
use Spatie\MediaLibrary\Conversions\ConversionCollection;
use Spatie\MediaLibrary\Conversions\FileManipulator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;


class PerformConversionsJob implements ShouldQueue
{
    /*https://github.com/spatie/laravel-medialibrary/issues/1281*/

    use InteractsWithQueue, Queueable;

    public bool $deleteWhenMissingModels = true;

    public function __construct(protected ConversionCollection $conversions, protected Media $media, protected bool $onlyMissing = false)
    {
    }

    public function handle(FileManipulator $fileManipulator): bool
    {
        $fileManipulator->performConversions($this->conversions, $this->media, $this->onlyMissing);

        return true;
    }
}
