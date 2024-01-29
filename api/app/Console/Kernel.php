<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Waynestate\Nova\CKEditor4Field\Jobs\PruneStaleAttachments as PruneStaleAttachmentsCKEditor;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        //if (config('app.env') === 'prod') {
        //    $schedule->command('backup:run')->daily()->at('03:00');
        //    $schedule->command('backup:clean')->daily()->at('04:00');
        //    $schedule->command('backup:monitor')->daily()->at('05:00');
        //}

        //$schedule->call(function () {(new PruneStaleAttachments)();})->daily();
        $schedule->call(function () {(new PruneStaleAttachmentsCKEditor)();})->daily(); // CKEditor
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
