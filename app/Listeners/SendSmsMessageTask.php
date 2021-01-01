<?php

namespace App\Listeners;

use App\Events\SmsMessageSaved;
use App\Models\Customer;
use App\Models\PopupAd;
use App\Models\SmsSendMessageTask;
use App\Services\VgSms;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendSmsMessageTask
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
     * @param  SmsMessageSaved  $event
     * @return void
     */
    public function handle(SmsMessageSaved $event)
    {
        $smsMessage = $event->smsMessage;

        $vgSms = new VgSms();
        Customer::select('phone')
            ->whereNotNUll('phone')
            ->where('id', '>', 16599)
            ->oldest()
            ->chunk(950, function ($customers) use($vgSms, $smsMessage) {
                // 发送短信
                $result = $vgSms->send($smsMessage, $this->getPhone($customers));
                Log::debug($result);
                if ($result['code'] != 0) {
                    $smsMessage->update([
                        'state' => $result['msg'],
                    ]);
                    return false;
                } else {
                    $smsMessage->update([
                        'state' => '任务推送成功',
                    ]);
                    // 保存任务编号
                    $smsMessage->tasks()->create([
                        'task_id' => $result['data']['taskid'],
                        'total' => count($customers),
                    ]);
                }
            }
        );
    }

    /**
     * 获取符合条件的手机号
     *
     * @param $customers
     * @return array
     */
    private function getPhone($customers) : array
    {
        $phone = [];
        foreach ($customers as $customer) {
            if (strlen($customer->phone) == 11) {
                $phone[] = $customer->phone;
            }
        }
        return $phone;
    }
}
