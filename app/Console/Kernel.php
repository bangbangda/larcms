<?php

namespace App\Console;

use App\Console\Commands\MiniDailyVisitTrend;
use App\Console\Commands\MiniUserPortrait;
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
        MiniDailyVisitTrend::class, // 查询获取用户访问小程序数据日趋势
        MiniUserPortrait::class,   // 查询小程序新增或活跃用户的画像分布数据
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('MiniDailyVisitTrend')->dailyAt('02:00');
        $schedule->command('MiniUserPortrait')->dailyAt('02:00');
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
