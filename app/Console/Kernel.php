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
    protected function schedule(Schedule $schedule)
{
    $schedule->call(function () {
        $expiredFiles = FileLink::where('expires_at', '<', now())->get();
        
        foreach ($expiredFiles as $file) {
            Storage::delete($file->storage_path);
            $file->delete();
        }
    })->daily();
}
}
