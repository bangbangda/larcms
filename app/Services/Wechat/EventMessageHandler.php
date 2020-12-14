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

        Log::debug($message);

        // 关注公众号推送
        if ($message['Event'] == 'subscribe') {
            // 更新或创建用户信息
            $wechatUser = $app->user->get($message['FromUserName']);
            // 关注欢迎词
            return $this->sayHello();
        } else if ($message['Event'] == 'click') {  // 点击事件
            // 根据不同的 key 返回欢迎词
            return $this->clickMessage($message['EventKey']);
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
        $text = new Text("");
        $text->content = "相遇淹南 际会新贵
 汲取千年淹城人居精神
匠著现代美学豪宅住区
淹南芯     双地铁
双商综 百年名校
约100-160㎡奢装地暖洋房

- 汝悦春秋 华彩敬献 -
咨询热线：0519-8599 3333
项目地址：常州武进区九州喜来登酒店南100米";

        return $text;
    }


    /**
     * 处理点击事件返回信息
     *
     * @param  string  $eventKey
     * @return Text
     */
    private function clickMessage(string $eventKey): Text
    {
        $text = new Text("");
        if ($eventKey == 'activity') {
            $text->content = "您好，感谢参与。通过“汝悦春秋”小程序分享后需要有好友进入并完成分享即可有收到红包，分享越多，收获越多。活动仅覆盖常州市武进区，超出区域将无法参与。由于活动火爆，红包发放可能会有延迟。每晚23点到第二日早9点为系统维护时间，系统维护时间内分享无法获得红包，敬请悉知。";
        }

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