<?php

namespace App\Jobs;

use EasyWeChat\Factory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * 发送小程序名片
 */
class SendMiniProgramPage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public string $openid)
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
        $app = Factory::officialAccount(config('wechat.mp'));

        // 发送小程序名片
        $result = $app->customer_service->send([
            'touser' => $this->openid,
            'msgtype' => 'miniprogrampage',
            'miniprogrampage' => [
                'title' => "你好，【远洲大都会】送你一个大红包，点击领取。",
                'appid' => config('wechat.mini_app.app_id'),
                'pagepath' => 'pages/home/home',
                'thumb_media_id' => '0X7Gg9TRbh5YkTm1MpkpF6K8BfFQ_aWvK7lwvU5UImE'
            ],
        ]);

        if ($this->isOk($result)) {
            Log::info('【关键字回复】成功推送小程序');
        } else {
            Log::error('【关键字回复】推送小程序失败 ' . $result['errcode']);
        }
    }

    /**
     * 验证接口返回结果
     *
     * @param array $result
     * @return bool
     */
    private function isOk(array $result): bool
    {
        return $result['errcode'] == '0' && $result['errmsg'] == 'ok';
    }
}
