<?php

namespace App\Http\Controllers;

use App\Services\Wechat\EventMessageHandler;
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
        $app = Factory::officialAccount(config('wechat.mp'));

        $app->server->push(EventMessageHandler::class, Message::EVENT);

        return $app->server->serve();
    }
}
