<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use EasyWeChat\Factory;
use Illuminate\Console\Command;
use App\Models\MpDailySummary as MpDailySummaryModel;

/**
 * 获取用户关注公众号数据概况
 *
 * Class MpDailySummary
 * @package App\Console\Commands
 */
class MpDailySummary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mp:dailySummary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '获取用户关注公众号数据概况';

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
        $this->info('开始获取用户关注公众号数据概况');
        $mpApp = Factory::officialAccount(config('wechat.mp'));

        $fromDate = $toDate = Carbon::yesterday()->format('Ymd');
        // 获取用户增减数据
        $dailySummary = $mpApp->data_cube->userSummary($fromDate, $toDate);
        $mpDailySummary = new MpDailySummaryModel();
        $mpDailySummary->insert($dailySummary['list']);

        // 获取累计用户数据
        $userCumulate = $mpApp->data_cube->userCumulate($fromDate, $toDate);
        MpDailySummaryModel::where('ref_date', $fromDate)->update([
            'cumulate_user' => $userCumulate['list'][0]['cumulate_user']
        ]);
        $this->info('结束获取用户关注公众号数据概况');
        return 0;
    }
}
