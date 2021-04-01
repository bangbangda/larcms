<?php

namespace App\Listeners;

use App\Events\SmsMessageSaved;
use App\Models\Customer;
use App\Services\VgSms;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendSmsMessageTask implements ShouldQueue
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
            ->whereRaw('length(phone) = 11')
            ->groupBy('phone')
            ->chunk(950, function ($customers) use($vgSms, $smsMessage) {
                $phones = $customers->pluck('phone')->toArray();
                // 发送短信
                $result = $vgSms->send($smsMessage, $phones);
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
                        'total' => count($phones),
                    ]);
                }
            }
        );
    }
}
