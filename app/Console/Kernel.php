<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Mining;
use App\Jobs\SwapMiningIncome;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->job( new SwapMiningIncome(new Mining))->everyMinute();
        $schedule->command('test:command')->everyMinute();

        dispatch(new SwapMiningIncome(new Mining));
    }
//* * * * * /usr/bin/php-7.1 /home2/u11592hqh/domain/omojekom.com/dev.omojekom.com/web/artisan schedule:run >> /dev/null 2>&1
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
