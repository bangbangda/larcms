<?php

namespace App\Listeners;

use App\Events\CustomerSubscribed;
use App\Models\Customer;
use EasyWeChat\Factory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * 用户关注公众号-自动发送小程序卡片
 *
 * Class SendMiniProgramPage
 * @package App\Listeners
 */
class SendMiniProgramPage implements ShouldQueue
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
     * @param  CustomerSubscribed  $event
     * @return void
     */
    public function handle(CustomerSubscribed $event)
    {
        $app = Factory::officialAccount(config('wechat.mp'));

        $message = $event->message;

        // 获取用户信息
        $customer = Customer::find($this->getEventKey($message['EventKey']));

        if (is_null($customer)) {
            Log::error("用户关注公众号上级编号不存在 {$this->getEventKey($message['EventKey'])}");
            return ;
        }

        // 发送小程序名片
        $result = $app->customer_service->send([
            'touser' => $message['FromUserName'],
            'msgtype' => 'miniprogrampage',
            'miniprogrampage' => $this->getMiniProgramPage($customer->nickname),
        ]);

        if ($this->isOk($result)) {
            Log::info('【用户关注】成功推送小程序');
        } else {
            Log::error('【用户关注】推送小程序失败 ' . $result['errcode']);
        }
    }

    /**
     * 获取小程序卡片信息
     *
     * @param string $nickname
     * @return array
     */
    private function getMiniProgramPage(string $nickname)
    {

        return [
            'title' => "你的好友【{$nickname}】送你一个大红包，点击领取。",
            'appid' => config('wechat.mini_app.app_id'),
            'pagepath' => 'pages/home/home',
            'thumb_media_id' => '0X7Gg9TRbh5YkTm1MpkpF-LVEDzeqn8Di9Rs1VCh6WQ'
        ];
    }

    /**
     * 获取 EventKey 数据
     *    删除对应固定的字符串，获取真实参数
     *
     * @param string $eventKey
     * @return string
     */
    private function getEventKey(string $eventKey): string
    {
        return Str::replaceFirst('qrscene_', '', $eventKey);
    }

    /**
     * 验证接口返回结果
     *
     * @param array $result
     * @return bool
     */
    private function isOk(array $result): bool
    {
        return $result['errcode'] == '0' && $result['errmsg'] == 'ok';
    }
}
