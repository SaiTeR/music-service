<?php

namespace App\Console;

use App\Console\Commands\UpdateAlbumsPlaybacks;
use App\Jobs\ArtisanCommandJob;
use Illuminate\Console\Scheduling\CallbackEvent;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        UpdateAlbumsPlaybacks::class,
    ];


    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        // $schedule->command('app:update-albums-playbacks')->everyMinute();
        $this->job($schedule, 'app:update-albums-playbacks', 'default')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    private function job(Schedule $schedule, string $commandName, string $queue): CallbackEvent
    {
        return $schedule->job(new ArtisanCommandJob($commandName), $queue);
    }
}
