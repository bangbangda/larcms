<?php

namespace App\Console\Commands;

use App\Models\DailySummary;
use Carbon\Carbon;
use EasyWeChat\Factory;
use Illuminate\Console\Command;

/**
 * 获取用户访问小程序数据概况
 *
 * Class MiniDailySummary
 * @package App\Console\Commands
 */
class MiniDailySummary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mini:dailySummary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '获取用户访问小程序数据概况';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $miniApp = Factory::miniProgram(config('wechat.mini_app'));

        $date = Carbon::yesterday()->format('Ymd');

        $summaryTrend = $miniApp->data_cube->summaryTrend($date, $date);

        $dailySummary = new DailySummary;
        $dailySummary->fill($summaryTrend['list'][0])->save();

        return 0;
    }
}
