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
    protected $signature = 'mini:dailySummary {date?}';

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
        $this->info('开始获取用户访问小程序数据概况..');
        $miniApp = Factory::miniProgram(config('wechat.mini_app'));

        if (! empty($this->argument('date'))) {
            $date = $this->argument('date');
        } else {
            $date = Carbon::yesterday()->format('Ymd');
        }
        $this->info("获取数据日期为 $date");
        $summaryTrend = $miniApp->data_cube->summaryTrend($date, $date);

        $dailySummary = new DailySummary;
        $dailySummary->fill($summaryTrend['list'][0])->save();

        $this->info('结束获取用户访问小程序数据概况..');
        return 0;
    }
}
