<?php

namespace App\Jobs;

use App\Models\Customer;
use EasyWeChat\Factory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * 批量获取用户信息
 *    系统上线前，自动获取公众号原粉丝，无缝通过 unionid 做业务判断。
 *
 * @package App\Jobs
 */
class GetWechatUserInfo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public array $openid)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mpApp = Factory::officialAccount(config('wechat.mp'));

        foreach ($this->openid as $openId) {
            if (Customer::where('mp_openid', $openId)->doesntExist()) {
                $user = $mpApp->user->get($openId);
                Customer::create([
                    'unionid' => $user['unionid'],
                    'mp_openid' => $openId,
                    'nickname' => $user['nickname'],
                    'avatar_url' => $user['headimgurl'],
                    'subscribe_time' => $user['subscribe_time'],
                    'subscribe_scene' => $user['subscribe_scene'],
                    'qr_scene' => $user['qr_scene'],
                    'qr_scene_str' => $user['qr_scene_str']
                ]);
            }
        }
    }
}
