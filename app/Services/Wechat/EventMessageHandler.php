<?php
namespace App\Services\Wechat;

use EasyWeChat\Factory;
use EasyWeChat\Kernel\Contracts\EventHandlerInterface;
use EasyWeChat\Kernel\Messages\Text;
use \Illuminate\Support\Facades\Log;
use App\Models\Customer;
use Illuminate\Support\Str;

class EventMessageHandler implements EventHandlerInterface
{

    /**
     * @inheritDoc
     */
    public function handle($payload = null)
    {
        $app = Factory::officialAccount(config('wechat.mp'));

        $message = $app->server->getMessage();

        // 关注公众号推送
        if ($message['Event'] == 'subscribe') {
            // 更新或创建用户信息
            $wechatUser = $app->user->get($message['FromUserName']);
            // 关注欢迎词
            return $this->sayHello();
        }
    }

    /**
     * 更新或创建用户信息
     *
     * @param  array  $wechatUser
     */
    private function updateUser(array $wechatUser)
    {
        Log::debug($wechatUser);

        Customer::updateOrCreate(
            ['unionid' => $wechatUser['unionid']],
            [
                'nickname' => $wechatUser['nickname'],
                'mp_openid' => $wechatUser['openid'],
                'avatar_url' => $this->urlToHttps($wechatUser['headimgurl']),
                'subscribe_scene' => $wechatUser['subscribe_scene'],
                'subscribe_time' => date('Y-m-d H:i:s', $wechatUser['subscribe_time']),
                'qr_scene' => $wechatUser['qr_scene'],
                'qr_scene_str' => $wechatUser['qr_scene_str']
            ]
        );
    }

    /**
     * 关注欢迎词
     *
     * @return Text
     */
    private function sayHello()
    {
        $text = new Text();
        $text->content = "欢迎关注!";
        return $text;
    }


    /**
     * 地址转为HTTPS链接
     *
     * @param  String  $headimgUrl
     * @return string
     */
    private function urlToHttps(String $headimgUrl)
    {
        return Str::replaceFirst('http:', 'https:', $headimgUrl);
    }
}