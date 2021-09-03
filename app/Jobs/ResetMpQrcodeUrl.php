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
use Illuminate\Support\Facades\Log;

class ResetMpQrcodeUrl implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $baseUri = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=';

    public int $tries = 5;

    public int $maxExceptions = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public array $customerId)
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

        foreach ($this->customerId as $id) {
            $result = $app->qrcode->temporary($id, 2592000);

            if (isset($result['ticket'])) {
                Customer::where('id', $id)->update([
                    'mp_qrcode_url' => $this->baseUri . $result['ticket']
                ]);
            } else {
                Log::error('重置带参数二维码失败 ' . $result['errcode'] . ' ' . $id);
                $this->fail(new \Exception($result['errmsg'], $result['errcode']));
            }
        }
    }
}
