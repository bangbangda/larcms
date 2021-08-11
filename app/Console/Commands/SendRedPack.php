<?php

namespace App\Console\Commands;

use App\Models\Customer;
use EasyWeChat\Factory;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SendRedPack extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wechat:red-pack-for-user-id';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '向OpenID发送红包';

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
        if ($this->confirm('确认向指定用户发送红包吗？')) {

            $this->info('该操作不会保留任何痕迹，仅限于发送奖金。');

            $user = Customer::find($this->ask('请输入用户编号'));

            $this->info('用户昵称：' . $user->nickname);

            $amount = $this->ask('请输入红包金额，单位元');

            if ($this->confirm('发送红包金额' . $amount . '元')) {
                if ($this->sendRedPack($user->mp_openid, $amount * 100)) {
                    $this->info('红包发送成功！🧧');
                } else {
                    $this->error('红包发送失败！');
                }
            }
        }

        return 0;
    }


    /**
     * 发送红包
     *
     * @param string $openid 用户编号
     * @param int $amount 金额（分）
     * @return bool
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function sendRedPack(string $openid, int $amount): bool
    {
        $wechatPay = Factory::payment(config('wechat.pay'));

        $result = $wechatPay->redpack->sendNormal([
            'mch_billno' => 'redpack' . Str::random(9),
            'send_name' => '远洲大都汇',
            're_openid' => $openid,
            'total_amount' => $amount,
            'total_num' => 1,
            'wishing' => '感谢您参加【远洲周年庆 狂欢嗨购月】活动',
            'act_name' => '远洲周年庆 狂欢嗨购月',
            'remark' => '分享越多 红包越多',
            'scene_id' => 'PRODUCT_2',
        ]);

        return $result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS';
    }
}
