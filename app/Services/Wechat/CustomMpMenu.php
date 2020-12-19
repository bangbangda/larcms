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
                'name' => '小程序',
                'type' => 'miniprogram',
                'url' => 'https://larcms.bangbangda.me',
                'appid' => 'wx7332a6a8af2c9ea6',
                'pagepath' => 'pages/home/home'
            ],
            [
                'name' => '武进买房人',
                'type' => 'click',
                'key' => 'video',
            ]
        ];

        $this->mpApp->menu->create($menu);
    }
}