<?php

namespace App\Console\Commands;

use App\Models\DailyVisitTrend;
use Carbon\Carbon;
use EasyWeChat\Factory;
use Illuminate\Console\Command;

/**
 * 获取用户访问小程序数据日趋势
 *
 * Class MiniDailyVisitTrend
 * @package App\Console\Commands
 */
class MiniDailyVisitTrend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mini:dailyVisitTrend';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '获取用户访问小程序数据日趋势';

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

        $visitTrend = $miniApp->data_cube->dailyVisitTrend($date, $date);

        $dailyVisitTrend = new DailyVisitTrend;
        $created = $dailyVisitTrend->fill($visitTrend['list'][0])->save();

        if ($created) {
            $this->info(Carbon::now() . " 成功获取用户访问小程序数据日趋势 [$date]");
        } else {
            $this->error(Carbon::now() . " 获取用户访问小程序数据日趋势失败 [$date]");
        }
    }
}
