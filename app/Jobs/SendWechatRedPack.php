<?php

namespace App\Jobs;

use App\Models\CustomerIncome;
use App\Models\TransferLog;
use EasyWeChat\Factory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SendWechatRedPack implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public array $redPack)
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
        $wechatPay = Factory::payment(config('wechat.pay'));

        $result = $wechatPay->redpack->sendNormal([
            'mch_billno' => 'redpack' . Str::random(9),
            'send_name' => '远洲大都汇',
            're_openid' => $this->redPack['mp_openid'],
            'total_amount' => $this->redPack['amount'],
            'total_num' => 1,
            'wishing' => '感谢您参加【远洲周年庆 狂欢嗨购月】活动',
            'act_name' => '远洲周年庆 狂欢嗨购月',
            'remark' => '分享越多 红包越多',
            'scene_id' => 'PRODUCT_2',
        ]);

        if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS') {
            // 增加用户收益金额
            $income = CustomerIncome::firstOrCreate([
                'customer_id' => $this->redPack['customer_id'],
            ], [
                'amount' => $this->redPack['amount'],
            ]);

            if (! $income->wasRecentlyCreated) {
                $income->update([
                    'amount' => $income->amount + $this->redPack['amount'],
                ]);
            }

            TransferLog::where('customer_id', $this->redPack['customer_id'])
                ->whereNull('payment_no')
                ->update([
                    'payment_no' => $result['mch_billno'],
                    'payment_time' => now()->toDateTimeString(),
                ]);

        } else {
            Log::error('微信红包发送失败'. $result['err_code']. ' | '. $result['err_code_des']);

            TransferLog::where('customer_id', $this->redPack['customer_id'])
                ->whereNull('payment_no')
                ->update([
                    'api_result' => json_encode($result),
                ]);
        }
    }

    /**
     * 确认接口是否执行成功
     *
     * @param  array  $result
     * @return bool
     */
    private function isSuccess(array $result) : bool
    {
        return $result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS';
    }
}
