<?php

namespace App\Console;

use App\Notifications\ApiNotify;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Stringable;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        // flights command
        $schedule->command('flight:api-store')->twiceDailyAt(4, 16)
            ->onSuccess(function () {
                Notification::route('mail', ['cfaisal009@gmail.com', 'khanusmann1269@gmail.com'])->notify(new ApiNotify("Execution was completed successfully."));
            })
            ->onFailure(function (Stringable $error) {  
                Notification::route('mail', ['cfaisal009@gmail.com', 'khanusmann1269@gmail.com'])->notify(new ApiNotify("There was an error in execution : $error"));
            });
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
