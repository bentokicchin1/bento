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
        $schedule->command('PlaceDefaultSubscription:placeDefaultSubscription')->dailyAt('05:58')->emailOutputTo('bentokicchin@gmail.com');
        $schedule->command('PlaceOrder:placeOrder')->dailyAt('06:00')->emailOutputTo('bentokicchin@gmail.com');

        $schedule->command('PlaceDefaultSubscription:placeDefaultSubscription')->dailyAt('11:28')->emailOutputTo('bentokicchin@gmail.com');
        $schedule->command('PlaceOrder:placeOrder')->dailyAt('11:30')->emailOutputTo('bentokicchin@gmail.com');

        $schedule->command('PlaceDefaultSubscription:placeDefaultSubscription')->dailyAt('18:28')->emailOutputTo('bentokicchin@gmail.com');
        $schedule->command('PlaceOrder:placeOrder')->dailyAt('18:30')->emailOutputTo('bentokicchin@gmail.com');
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
