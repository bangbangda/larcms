<?php

namespace App\Http\Controllers;

use App\Services\Wechat\EventMessageHandler;
use App\Services\Wechat\TextMessageHandler;
use Illuminate\Http\Request;
use EasyWeChat\Factory;
use EasyWeChat\Kernel\Messages\Message;


class WechatPushController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $app = Factory::officialAccount(config('wechat.mp'));dd($request->query());
        // 对应 octane
        $app->request->initialize($request->query(), $request->post());
        // 事件消息
        $app->server->push(EventMessageHandler::class, Message::EVENT);
        // 文本消息
        $app->server->push(TextMessageHandler::class, Message::TEXT);

        return $app->server->serve();
    }
}
