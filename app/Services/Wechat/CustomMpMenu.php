<?php
namespace App\Services\Wechat;

use EasyWeChat\Factory;

/**
 * 自定义公众号菜单
 *
 * Class CustomMpMenu
 * @package App\Services\Wechat
 */
class CustomMpMenu
{
    private $mpApp;

    public function __construct()
    {
        $this->mpApp = Factory::officialAccount(config('wechat.mp'));
    }

    /**
     * 创建菜单
     */
    public function create()
    {
        $menu = [
            [
                'name' => '了解项目',
                'sub_button' => [
                    [
                        'type' => 'view',
                        'name' => '汝悦春秋',
                        'url' => 'https://mp.weixin.qq.com/s/8hG4N3XPG1MJdSo6P5drNg'
                    ],
                    [
                        'type' => 'view',
                        'name' => 'VR看房',
                        'url' => 'https://t.cn/A65yBdEE'
                    ],
                    [
                        'type' => 'view',
                        'name' => '户型赏析',
                        'url' => 'https://mp.weixin.qq.com/s/Yzo6xNQmP8rKIcTsmekdPw',
                    ],
                    [
                        'type' => 'click',
                        'name' => '客服热线',
                        'key' => 'tel',
                    ],
                    [
                        'type' => 'view',
                        'name' => '地图导航',
                        'url' => 'https://map.qq.com/m/place/info/uid=18432199695127632302&word=%E6%B1%9D%E6%82%A6%E6%98%A5%E7%A7%8B&type=point'
                    ]
                ],
            ],
            [
                'name' => '泛会所',
                'sub_button' => [
                    [
                        'type' => 'view',
                        'name' => '新贵意境',
                        'url' => 'https://mp.weixin.qq.com/s/y5u-V153pM3ZTj1OStfjhw'
                    ]
                ]
            ],
            [
                'name' => '小程序',
                'type' => 'miniprogram',
                'url' => 'https://larcms.bangbangda.me',
                'appid' => 'wx7332a6a8af2c9ea6',
                'pagepath' => 'pages/home/home'
            ]
        ];

        $this->mpApp->menu->create($menu);
    }
}