<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ReindexSearch extends Command
{
    protected $signature = 'search:reindex';
    protected $description = 'Reindex search';

    public function handle()
    {
        Artisan::call('scout:import "App\\\Models\\\Product"');
    }
}



