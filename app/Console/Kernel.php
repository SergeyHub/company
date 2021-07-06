<?php

namespace App\Console;

use App\Console\Commands\GirlFillProfileNotify;
use App\Console\Commands\GirlUploadPhotoNotify;
use App\Console\Commands\LeaveOnlyEnglishInCountries;
use App\Console\Commands\SendUnreadMessageNotifications;
use App\Console\Commands\UpdateCountriesStats;
use App\Console\Commands\CheckVipExpired;
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
        UpdateCountriesStats::class,
        LeaveOnlyEnglishInCountries::class,
        GirlFillProfileNotify::class,
        GirlUploadPhotoNotify::class,
        SendUnreadMessageNotifications::class,
        CheckVipExpired::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('countries:stats')
            ->everyTenMinutes();

        $schedule->command('messages:unread-noty')
            ->everyFiveMinutes();
        /*
        $schedule->command('notify:girl-photos')
            ->cron('0 12 * * *');

        $schedule->command('notify:girl-profile')
            ->cron('0 12 * * *');
        */
        $schedule->command('backup:clean')->daily()->at('01:00');

        $schedule->command('backup:run')->daily()->at('02:00');

        $schedule->command('medialibrary:regenerate')->hourly();

        $schedule->command('vip:expired')->daily()->at('01:00');
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
