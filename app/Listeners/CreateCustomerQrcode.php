<?php

namespace App\Listeners;

use App\Events\CustomerRegistered;
use EasyWeChat\Factory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * 用户场景时 自动更新专属小程序码
 *
 * Class CreateCustomerQrcode
 * @package App\Listeners
 */
class CreateCustomerQrcode
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
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     */
    private function qrCode($id)
    {
        $miniApp = Factory::miniProgram(config('wecaht.mini_app'));

        $response = $miniApp->app_code->getUnlimit($id, [
            'is_hyaline' => true
        ]);

        if (is_array($response)) {
            Log::error('获取小程序码失败');
            return '';
        }

        if ($response instanceof \EasyWeChat\Kernel\Http\StreamResponse) {
            $fileName = $response->saveAs(public_path('storage/qrcode/'), Str::random(8) . '.png');
        }

        return config('app.url'). '/storage/qrcode/'. $fileName;
    }
}
