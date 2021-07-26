<?php

namespace App\Console\Commands;

use App\Models\UserPortrait;
use Carbon\Carbon;
use EasyWeChat\Factory;
use Illuminate\Console\Command;

/**
 * 获取小程序新增或活跃用户的画像分布数据
 *
 * Class MiniUserPortrait
 * @package App\Console\Commands
 */
class MiniUserPortrait extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mini:userPortrait';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '获取小程序新增或活跃用户的画像分布数据';

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

        $userPortrait = $miniApp->data_cube->userPortrait($date, $date);

        $this->createVisitUvNew($userPortrait['visit_uv_new'], $date);

        $this->createVisitUv($userPortrait['visit_uv'], $date);

        return 0;
    }

    /**
     * 创建新用户画像
     *
     * @param  array  $visitUvNew
     * @param  string  $date
     */
    private function createVisitUvNew(array $visitUvNew, string $date)
    {
        $this->info("开始创建新用户画像..");
        $userPortrait = UserPortrait::create([
            'type' => 'visit_uv_new',
            'date_type' => 'day',
            'ref_date' => $date,
        ]);

        // 创建画像详细数据
        $this->visitUv($userPortrait, $visitUvNew);
        $this->info("结束创建新用户画像..");
    }

    /**
     * 活跃用户画像
     *
     * @param  array  $visitUv
     * @param  string  $date
     */
    private function createVisitUv(array $visitUv, string $date)
    {
        $this->info("开始创建活跃用户画像..");
        $userPortrait = UserPortrait::create([
            'type' => 'visit_uv',
            'date_type' => 'day',
            'ref_date' => $date,
        ]);

        // 创建画像详细数据
        $this->visitUv($userPortrait, $visitUv);
        $this->info("结束创建活跃用户画像..");
    }

    /**
     * 创建画像详细数据
     *   年龄、平台、机型、性别分布
     *
     * @param  UserPortrait  $userPortrait
     * @param  array  $visitUv
     */
    private function visitUv(UserPortrait $userPortrait, array $visitUv)
    {
        // 年龄分布
        foreach ($visitUv['ages'] as $ageUv) {
            $userPortrait->ages()->create([
                'name' => $ageUv['name'],
                'visit_uv' => $ageUv['value'],
            ]);
        }
        // 设备分布
        foreach ($visitUv['devices'] as $device) {
            $userPortrait->devices()->create([
                'name' => $device['name'],
                'visit_uv' => $device['value'],
            ]);
        }
        // 性别分布
        foreach ($visitUv['genders'] as $gender) {
            $userPortrait->genders()->create([
                'name' => $gender['name'],
                'visit_uv' => $gender['value'],
            ]);
        }

        // 性别分布
        foreach ($visitUv['platforms'] as $platform) {
            $userPortrait->platforms()->create([
                'name' => $platform['name'],
                'visit_uv' => $platform['value'],
            ]);
        }
    }
}
