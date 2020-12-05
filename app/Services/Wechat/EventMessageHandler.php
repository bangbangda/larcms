<?php
namespace App\Services\Wechat;

use EasyWeChat\Factory;
use EasyWeChat\Kernel\Contracts\EventHandlerInterface;
use \Illuminate\Support\Facades\Log;
use App\Models\Customer;

class EventMessageHandler implements EventHandlerInterface
{

    /**
     * @inheritDoc
     */
    public function handle($payload = null)
    {
        $app = Factory::officialAccount(config('wechat.mp'));

        $message = $app->server->getMessage();

        if ($message['Event'] == 'subscribe') {

            $wechatUser = $app->user->get($message['FromUserName']);
            Log::debug($wechatUser);

            Customer::updateOrCreate(
                ['unionid' => $wechatUser['unionid']],
                [
                    'nickname' => $wechatUser['nickname'],
                    'mp_openid' => $wechatUser['openid'],
                    'avatar_url' => $wechatUser['headimgurl'],
                    'subscribe_scene' => $wechatUser['subscribe_scene'],
                    'qr_scene' => $wechatUser['qr_scene'],
                    'qr_scene_str' => $wechatUser['qr_scene_str']
                ]
            );

        }
    }
}