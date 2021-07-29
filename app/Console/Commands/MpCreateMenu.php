<?php

namespace App\Console\Commands;

use EasyWeChat\Factory;
use Illuminate\Console\Command;

class MpCreateMenu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mp:create-menu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建公众号菜单';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $mpApp = Factory::officialAccount(config('wechat.mp'));

        $result = $mpApp->menu->create($this->getMenu());

        if ($result['errcode'] == '0') {
            $this->info('菜单创建完成');
        } else {
            $this->error('菜单创建失败：错误编号 ' . $result['errcode']);
        }

        return 0;
    }

    /**
     * 获取菜单数据
     *
     * @return array
     */
    private function getMenu(): array
    {
        return [
            [
                'name' => '品·远洲',
                'sub_button' => [
                    [
                        'type' => 'view',
                        'name' => '远洲集团',
                        'url' => 'http://mp.weixin.qq.com/s?__biz=MzIzNzAxNTcxMA==&mid=100000014&idx=1&sn=265badf52ab6de72f4140b767c92e025&chksm=68ce46ff5fb9cfe90aac0ee1cf892b5273be8aad1bf28088f3a21bb74e98c5bc321490396f80&scene=18#wechat_redirect'
                    ], [
                        'type' => 'view',
                        'name' => '远洲旅业',
                        'url' => 'http://mp.weixin.qq.com/s?__biz=MzIzNzAxNTcxMA==&mid=100000116&idx=1&sn=86d47bdc43daa0aff15ab1d534e6a294&chksm=68ce46855fb9cf93b5e6d0d6d908ebe8a655735c88b295f23932974cdf0601c565184f95d250&scene=18#wechat_redirect'
                    ], [
                        'type' => 'view',
                        'name' => '远洲石化',
                        'url' => 'http://mp.weixin.qq.com/s?__biz=MzIzNzAxNTcxMA==&mid=100000013&idx=1&sn=3ac8ee4f3914cef21158885c53e9693d&chksm=68ce46fc5fb9cfea67fb97fff69cd1a99f559fcafbcd8ba9424a9aef6065ffc3fc5b6c960bc6&scene=18#wechat_redirect'
                    ], [
                        'type' => 'view',
                        'name' => '远洲房产',
                        'url' => 'http://mp.weixin.qq.com/s?__biz=MzIzNzAxNTcxMA==&mid=100000006&idx=1&sn=e337ee1d21ba491fa2de3a7c37969c87&chksm=68ce46f75fb9cfe1c6cb5dde3550c9675f9d975b4e4dac331d53826968e3cbb7fe4de96e58cf&scene=18#wechat_redirect'
                    ],
                ]
            ], [
                'name' => '鉴·远洲',
                'sub_button' => [
                    [
                        'type' => 'view',
                        'name' => '瞰景高层',
                        'url' => 'https://s.wcd.im/v/6b7t1Z39/?slv=1&sid=b6dm&v=oosnVwq25frKAkKMTwcdQ4AqjS10'
                    ], [
                        'type' => 'view',
                        'name' => '舒阔小高',
                        'url' => 'https://s.wcd.im/v/6b7t1Z3a/?slv=1&sid=b6dm&v=oosnVwq25frKAkKMTwcdQ4AqjS10'
                    ], [
                        'type' => 'view',
                        'name' => '臻奢洋房',
                        'url' => 'https://s.wcd.im/v/6b7t1Z3b/?slv=1&sid=b6dm&v=oosnVwq25frKAkKMTwcdQ4AqjS10'
                    ], [
                        'type' => 'view',
                        'name' => '注册经纪人',
                        'url' => 'https://qmyxcg.myscrm.cn/broker/index/index?token=qfcjnv1586327809'
                    ], [
                        'type' => 'view',
                        'name' => '远洲.大都汇',
                        'url' => 'http://mp.weixin.qq.com/s?__biz=MzIzNzAxNTcxMA==&mid=100000002&idx=1&sn=e80991da4fa03934b7986d1fdb4190d5&chksm=68ce46f35fb9cfe5ae6d03dcef7f389340861848e860a35256806296c75b098ca394cbcb42bf&scene=18#wechat_redirect'
                    ]
                ],
            ], [
                'type' => 'view',
                'name' => '水世界',
                'url' => 'https://a.eqxiu.com/s/2eGleXzD'
            ]
        ];
    }
}
