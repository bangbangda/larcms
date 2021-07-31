<?php

namespace App\Console\Commands;

use App\Jobs\GetWechatUserInfo;
use EasyWeChat\Factory;
use Illuminate\Console\Command;

class MpPullUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mp:pull-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '拉取公众号现有粉丝';

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
        if ($this->confirm('请确认要将公众号粉丝全部导入吗？')) {
            $mpApp = Factory::officialAccount(config('wechat.mp'));
            // 获取所有用户
            $users = $mpApp->user->list();

            $this->info("公众号总用户数：{$users['total']}");
            $this->info("本次拉取用户数：{$users['count']}");

            // 拆分200个用户为一个队列，批量获取用户信息
            $openidArr = array_chunk($users['data']['openid'], 200);

            foreach ($openidArr as $openid) {
                GetWechatUserInfo::dispatch($openid);
            }
            $this->info('队列添加完成，请确认数据是否更新完成');
        }

        return 0;
    }
}
