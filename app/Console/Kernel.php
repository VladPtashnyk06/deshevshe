<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('orders:clear-json')->daily();
        $schedule->command('import:product-data')->everyThirtyMinutes();
        $schedule->command('novaposhta:update-data')->monthly();
        $schedule->command('novaposhta:settlement-update-data')->monthly();
        $schedule->command('novaposhta:warehouse-update-data')->dailyAt('03:00');
        $schedule->command('meest:update-data')->weekly();
        $schedule->command('ukrposhta:update-data')->weekly();
        $schedule->command('novaposhta:update-status-ttn-data')->dailyAt('20:00');
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
