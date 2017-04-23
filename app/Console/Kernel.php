<?php

namespace App\Console;

use App\Mailing;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [];

    protected function schedule(Schedule $schedule)
    {
        foreach(Mailing::all() as $mailing){
            $schedule->command('send:email '.$mailing->id)->cron($mailing->cron_job);
        }
    }

    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
