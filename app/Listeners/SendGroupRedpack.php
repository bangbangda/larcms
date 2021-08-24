<?php

namespace App\Listeners;

use App\Events\WechatUserRegistered;
use EasyWeChat\Factory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SendGroupRedpack
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  WechatUserRegistered  $event
     * @return void
     */
    public function handle(WechatUserRegistered $event)
    {
        $wechatPay = Factory::payment(config('wechat.pay'));

        $result = $wechatPay->redpack->sendGroup([
            'mch_billno'   => Str::random(),
            'send_name'    => '远洲大都汇',
            're_openid'    => $event->openid,
            'total_num'    => 3,  //不小于3
            'total_amount' => 300,  //单位为分，不小于300
            'wishing' => '感谢您参加【远洲周年庆 狂欢嗨购月】活动',
            'act_name' => '远洲周年庆 狂欢嗨购月',
            'remark' => '分享越多 红包越多',
            'amt_type' => 'ALL_RAND',
            'scene_id' => 'PRODUCT_2',
        ]);
        Log::debug('wechat pay..');
        Log::debug($result);
    }
}
