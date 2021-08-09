<?php

namespace App\Console\Commands;

use EasyWeChat\Factory;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class WechatSendRedPack extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wechat:send-red-pack';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $wechatPay = Factory::payment(config('wechat.pay'));

        $result = $wechatPay->redpack->sendNormal([
            'mch_billno' => Str::random(9),
            'send_name' => '远洲大都汇分享红包礼（团队红包）',
            're_openid' => 'onvDwwLkeUvDL4UHfh3oQPeD5Kz4',
            'total_amount' => 1,
            'total_num' => 1,
            'wishing' => '感谢您参加【远洲周年庆 狂欢嗨购月】活动',
            'act_name' => '远洲周年庆 狂欢嗨购月',
            'remark' => '分享越多 红包越多',
            'scene_id' => 'PRODUCT_2',
        ]);

        if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS') {
            $this->info('红包发放成功');
        } else {
            $this->error('红包发放失败' . $result['err_code']);
        }

        return 0;
    }
}
