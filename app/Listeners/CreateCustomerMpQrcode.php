<?php

namespace App\Listeners;

use App\Events\CustomerRegistered;
use EasyWeChat\Factory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

/**
 * 生成公众号带参数二维码
 *
 * Class CreateCustomerMpQrcode
 * @package App\Listeners
 */
class CreateCustomerMpQrcode implements ShouldQueue
{

    private string $baseUri = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=';
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CustomerRegistered  $event
     * @return void
     */
    public function handle(CustomerRegistered $event)
    {
        $app = Factory::officialAccount(config('wechat.mp'));

        $model = $event->model;

        $result = $app->qrcode->temporary($model->id, 60 * 60 * 24 * 29);

        if (isset($result['ticket'])) {
            $model->update([
                'mp_qrcode_url' => $this->baseUri . $result['ticket']
            ]);
            Log::info("生成公众号带参数二维码成功");
        } else {
            Log::error("生成公众号带参数二维码失败：{$result}");
        }
    }

}
