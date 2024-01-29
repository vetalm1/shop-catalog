<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ImageRegenerateCommand extends Command
{
    protected $signature = 'images:regenerate';
    protected $description = 'Regenerating images';

    /*tutorial = https://spatie.be/docs/laravel-medialibrary/v11/converting-images/regenerating-images*/

    public function handle()
    {
        Artisan::call('php artisan media-library:regenerate "App\Models\Product"');
    }
}



