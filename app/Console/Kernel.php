<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected $commands = [
        //
        Commands\DailyRevenueDriver::class
    ];
    protected function schedule(Schedule $schedule)
    {
        // php artisan schedule:work
        // php artisan schedule:run
        // $schedule->command('inspire')->hourly();
        // $schedule->command('daily:revenue')->everyMinute()->appendOutputTo('schedule.log');
        $schedule->command('daily:revenue')->hourly();
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
