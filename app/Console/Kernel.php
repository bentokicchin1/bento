<?php

namespace App\Console;

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
        '\App\Console\Commands\PlaceOrder',
        '\App\Console\Commands\PlaceDefaultSubscription',
        '\App\Console\Commands\GenerateMonthlyBills',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Mail::send('errors.404', array(), function($message)
        // {
        //     $message->to('skhilari26@gmail.com', 'Shital')->subject('Welcome!');
        // });
        $schedule->command('PlaceDefaultSubscription:placeDefaultSubscription')->between('06:55','11:25')->everyFiveMinutes()->emailOutputTo('bentokicchin@gmail.com');
        $schedule->command('PlaceOrder:placeOrder')->between('07:00','11:30')->everyFiveMinutes()->emailOutputTo('bentokicchin@gmail.com');

        $schedule->command('PlaceDefaultSubscription:placeDefaultSubscription')->between('15:55','18:25')->everyFiveMinutes()->emailOutputTo('bentokicchin@gmail.com');
        $schedule->command('PlaceOrder:placeOrder')->between('15:30','18:30')->everyFiveMinutes()->emailOutputTo('bentokicchin@gmail.com');

        // $schedule->command('generateMonthlyBills:generateMonthlyBills')>daily()->emailOutputTo('bentokicchin@gmail.com');
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
