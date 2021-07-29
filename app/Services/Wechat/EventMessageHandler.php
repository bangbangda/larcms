<?php
namespace App\Services\Wechat;

use EasyWeChat\Factory;
use EasyWeChat\Kernel\Contracts\EventHandlerInterface;
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

        // 处理原有用户，重新扫码带参数二维码后，更新上级编号
        if (isset($message['EventKey']) &&
            Customer::where('unionid', $wechatUser['unionid'])->whereNull('parent_id')->exists()) {
            // 更新上级编号
            $customer = Customer::where('unionid', $wechatUser['unionid'])->get();
            $customer->parent_id = Str::replaceFirst('qrscene_', '', $message['EventKey']);
            $customer->save();

            // 发送小程序卡片
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
                'parent_id' => isset($message['EventKey']) ? Str::replaceFirst('qrscene_', '', $message['EventKey']) : null,
            ]);

            // 扫码关注场景
            if (isset($message['EventKey'])) {
                CustomerSubscribed::dispatch($message);
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
        $text->content = "欢迎关注【远洲·大都汇】公众号！
 
新都核芯 市政府旁 
钢三小远洲校区正式动工
约110-160㎡全程生活场
新品预约登记，火热进行中~
 
【远洲狂欢水世界】
这个8月去哪儿玩？来远洲·大都汇
万人水上狂欢，闯关赢惊喜大奖！
快点击右下角链接填写信息报名吧！！！
<活动时间>  8月7日--8月29日
<活动地点>  远洲·大都汇营销中心旁
 
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
}