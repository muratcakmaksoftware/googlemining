<?php

namespace App\Console;

use App\Console\Commands\TrafficAccident;
use App\Console\Commands\WorkAccident;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        TrafficAccident::class,
        WorkAccident::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('command:TrafficAccident')->everyThirtyMinutes()
            ->appendOutputTo(storage_path('logs/trafficAccident.log'));
        $schedule->command('command:WorkAccident')->everyThirtyMinutes()
            ->appendOutputTo(storage_path('logs/workAccident.log'));
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
