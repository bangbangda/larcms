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

        // 发送小程序名片
        $result = $app->customer_service->send([
            'touser' => $message['FromUserName'],
            'msgtype' => 'miniprogrampage',
            'miniprogrampage' => $this->getMiniProgramPage($message),
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
     * @param array $message
     * @return array
     */
    private function getMiniProgramPage(array $message)
    {
        if (! is_null($message['EventKey']) ) {
            // 获取用户信息
            $customer = Customer::find($this->getScene($message['EventKey']));

            if (! is_null($customer)) {
                return [
                    'title' => "你的好友【{$customer->nickname}】送你一个大红包，点击领取。",
                    'appid' => config('wechat.mini_app.app_id'),
                    'pagepath' => 'pages/home/home?parent_id=' . $this->getScene($message['EventKey']),
                    'thumb_media_id' => '0X7Gg9TRbh5YkTm1MpkpF6K8BfFQ_aWvK7lwvU5UImE'
                ];
            }

            Log::error("用户关注公众号上级编号不存在 {$this->getScene($message['EventKey'])}");
        } else {
            Log::debug("主动关注公众号，没有任何上级。[{$message['FromUserName']}]");
            return [
                'title' => "你好，【远洲大都会】送你一个大红包，点击领取。",
                'appid' => config('wechat.mini_app.app_id'),
                'pagepath' => 'pages/home/home',
                'thumb_media_id' => '0X7Gg9TRbh5YkTm1MpkpF6K8BfFQ_aWvK7lwvU5UImE'
            ];
        }
    }

    /**
     * 获取 EventKey 数据
     *    删除对应固定的字符串，获取真实参数
     *
     * @param string $eventKey
     * @return string
     */
    private function getScene(string $eventKey): string
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
