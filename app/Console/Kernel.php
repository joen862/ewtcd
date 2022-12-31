<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Market;
use App\Models\Wallet;
use App\Models\Supply;
use App\Models\Bridged;

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

        $schedule->command('checkblocks')->everyMinute()->withoutOverlapping(5);

        $schedule->call(function() {
            $market = new Market;
            $market->updateMarketData();
        })->everyFiveMinutes();

        $schedule->call(function() {
            $supply = new Supply;
            $supply->updateSupplyData();
        })->hourly();

        $schedule->call(function() {
            $bridged = new Bridged;
            $bridged->updateBridgedData();
        })->hourly();

        $schedule->call(function() {
            $wallet = new Wallet;
            $wallet->updateBalances();
        })->hourly();

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
