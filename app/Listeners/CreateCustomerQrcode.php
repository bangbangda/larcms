<?php

namespace App\Listeners;

use Anan\Oss\Facades\EasyOss;
use App\Events\CustomerRegistered;
use EasyWeChat\Factory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * 用户场景时 自动更新专属小程序码
 *
 * Class CreateCustomerQrcode
 * @package App\Listeners
 */
class CreateCustomerQrcode implements ShouldQueue
{
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
        $model = $event->model;
        $model->update([
            'qrcode_url' => $this->qrCode($model->id)
        ]);

    }


    /**
     * 创建用户小程序码
     *
     * @param $id
     * @return string
     */
    private function qrCode($id): string
    {
        $miniApp = Factory::miniProgram(config('wechat.mini_app'));
        // 使用 getUnlimited 接口获取小程序码
        $response = $miniApp->app_code->getUnlimit($id, [
            'page'  => 'pages/home/home',
        ]);

        if (is_array($response)) {
            Log::error('获取小程序码失败');
            Log::error($response);
            return '';
        }
        Log::debug('获取小程序码成功');

        $fileName = $response->saveAs(public_path('storage/qrcode/'), Str::random(8) . '.png');

        return EasyOss::uploadFile(public_path('storage/qrcode/' . $fileName));
    }
}
