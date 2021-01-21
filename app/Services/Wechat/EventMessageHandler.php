<?php
namespace App\Services\Wechat;

use EasyWeChat\Factory;
use EasyWeChat\Kernel\Contracts\EventHandlerInterface;
use EasyWeChat\Kernel\Messages\Text;
use EasyWeChat\Kernel\Messages\Video;
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
            $this->updateUser($app->user->get($message['FromUserName']));

            // 关注欢迎词
            return $this->sayHello();
        } else if ($message['Event'] == 'CLICK') {  // 点击事件
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

【你买房我买单】
未来三个月内如有在武进区购房（限住宅）计划
<全武进，不限项目>
<不含公寓/商业/别墅>
欢迎来汝悦春秋售楼处登记参加本活动
将有机会获得最高200万现金购房赞助

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
    private function clickMessage(string $eventKey)
    {
        if ($eventKey == 'tel') {
            $text = new Text();
            $text->content = '汝悦春秋咨询热线：0519-8599 3333';

            return $text;
        }
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