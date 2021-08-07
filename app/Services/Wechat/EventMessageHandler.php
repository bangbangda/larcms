<?php
namespace App\Services\Wechat;

use EasyWeChat\Factory;
use EasyWeChat\Kernel\Contracts\EventHandlerInterface;
use EasyWeChat\Kernel\Messages\Image;
use EasyWeChat\Kernel\Messages\Text;
use Illuminate\Support\Facades\Log;
use App\Models\Customer;
use App\Events\CustomerSubscribed;
use Illuminate\Support\Str;

class EventMessageHandler implements EventHandlerInterface
{

    /**
     * @inheritDoc
     */
    public function handle($payload = null)
    {
        $this->app = Factory::officialAccount(config('wechat.mp'));

        // 对应 octane
        $this->app->request->initialize(request()->query(), request()->post(), [], [], [], request()->server(), request()->getContent());

        $message = $this->app->server->getMessage();

        Log::debug($message);

        // 关注公众号
        if ($message['Event'] == 'subscribe') {
            // 更新或创建用户信息
            $this->updateUser($message);

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
     * @param array $message
     */
    private function updateUser(array $message)
    {
        // 获取用户基本信息
        $wechatUser = $this->app->user->get($message['FromUserName']);
        Log::debug($wechatUser);

        // 处理原有用户，重新扫码带参数二维码后，且该用户没有上级时，更新上级编号
        if (isset($message['EventKey']) &&
            Customer::where('unionid', $wechatUser['unionid'])->whereNull('parent_id')->exists()) {
            // 更新上级编号
            $customer = Customer::where('unionid', $wechatUser['unionid'])->first();
            $customer->parent_id = $this->getQrScene($message);
            $customer->save();

            // 用户关注公众号事件
            CustomerSubscribed::dispatch($message);
        }

        // 处理新用户关注
        if (Customer::where('unionid', $wechatUser['unionid'])->doesntExist()) {
            Customer::create([
                'unionid' => $wechatUser['unionid'],
                'nickname' => $wechatUser['nickname'],
                'mp_openid' => $wechatUser['openid'],
                'avatar_url' => $this->urlToHttps($wechatUser['headimgurl']),
                'subscribe_scene' => $wechatUser['subscribe_scene'],
                'subscribe_time' => date('Y-m-d H:i:s', $wechatUser['subscribe_time']),
                'qr_scene' => $wechatUser['qr_scene'],
                'qr_scene_str' => $wechatUser['qr_scene_str'],
                'parent_id' => $this->getQrScene($message),
            ]);

            // 用户关注公众号事件
            CustomerSubscribed::dispatch($message);
        }

        // 用户先打开小程序端 后关注公众号 直接更新公众号信息
        if (Customer::where('unionid', $wechatUser['unionid'])->whereNull('mp_openid')->exists()) {
            $customer = Customer::where('unionid', $wechatUser['unionid'])
                ->whereNull('mp_openid')
                ->first();

            $customer->update([
                'nickname' => $wechatUser['nickname'],
                'mp_openid' => $wechatUser['openid'],
                'avatar_url' => $this->urlToHttps($wechatUser['headimgurl']),
                'subscribe_scene' => $wechatUser['subscribe_scene'],
                'subscribe_time' => date('Y-m-d H:i:s', $wechatUser['subscribe_time']),
                'qr_scene' => $wechatUser['qr_scene'],
                'qr_scene_str' => $wechatUser['qr_scene_str'],
            ]);

            if (is_null($customer->parent_id)) {
                $customer->update([
                    'parent_id' => $this->getQrScene($message)
                ]);
            }
        }
    }

    /**
     * 关注欢迎词
     *
     * @return Text
     */
    private function sayHello(): Text
    {
        $text = new Text();
        $text->content = "公众号欢迎语更新
 
欢迎关注【远洲·大都汇】公众号！
 
新都核芯 市政府旁 
钢三小远洲校区正式动工
约110-160㎡全程生活场
新品预约登记，火热进行中~
 
【远洲周年庆 狂欢总动员】
20万现金红包全城派送！
线上直播，High出新优惠!
老业主归家，享万般美好
8月更多精彩，敬请期待! 
 
- 美好生活 都汇呈现 -
咨询热线：0472-216 6666
项目地址：新市政府东200米";

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

    /**
     * 获取二维码参数
     *
     * @param array $message
     * @return string|null
     */
    private function getQrScene(array $message)
    {
        return isset($message['EventKey']) ? Str::replaceFirst('qrscene_', '', $message['EventKey']) : null;
    }
}