<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivityRuleController extends Controller
{
    public function index()
    {
        $rule = [
            [
                'title' => '第一重奖励：新人红包',
                'content' => '奖励时间：12月6日-12月9日
奖励说明：首次下载自己的专属海报并分享出去，立即获得随机红包奖励，最高可得888元'
            ],
            [
                'title' => '第二重奖励：分享红包',
                'content' => '奖励说明：好友通过分享的海报二维码进入小程序，分享人即可获得奖励红包，每新增一人获得2元即时到账红包'
            ],
            [
                'title' => '第三重奖励：排名红包',
                'content' => '奖励说明：
每周海报分享排行榜，对所有参与活动的海报分享新增好友数量进行排名（好友通过海报二维码进入小程序计为有效分享），每周排行榜前20名将额外获得超大奖励！'
            ],
        ];

        return response()->json($rule);
    }
}
