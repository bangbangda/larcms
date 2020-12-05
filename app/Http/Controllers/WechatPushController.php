<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use EasyWeChat\Factory;

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
        $response = $app->server->serve();

        return $response->send();
    }
}
