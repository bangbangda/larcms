<?php

namespace App\Jobs;

use EasyWeChat\Factory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendGroupRedPacket implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public Model $groupRedPacket)
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

        $result = $wechatPay->redpack->sendGroup([
            'mch_billno'   => $this->groupRedPacket->bill_no,
            'send_name'    => '远洲大都汇',
            're_openid'    => $this->groupRedPacket->openid,
            'total_num'    => $this->groupRedPacket->total_num,
            'total_amount' => $this->groupRedPacket->total_amount,
            'wishing' => '感谢您参加【远洲周年庆 狂欢嗨购月】活动',
            'act_name' => '远洲周年庆 狂欢嗨购月',
            'remark' => '分享越多 红包越多',
            'amt_type' => 'ALL_RAND',
            'scene_id' => 'PRODUCT_2',
        ]);
        Log::debug('发送裂变红包结果');
        Log::debug($result);

        if ($this->isOk($result)) {
            $this->groupRedPacket->update([
                'status' => 'SENT',
            ]);
        } else {
            $this->groupRedPacket->update([
                'status' => 'FAILED',
                'fail_reason' => $result['err_code_des']
            ]);
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
        return $result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS';
    }
}
