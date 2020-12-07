<?php

namespace App\Listeners;

use App\Events\CustomerPhoneBound;
use App\Models\RedpackSetting;
use App\Models\TransferLog;
use App\Services\Wechat\TransferMoney;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Arr;

class NewcomerRedpack
{
    private const TYPE = 'newcomer';

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
     * @param  CustomerPhoneBound  $event
     * @return void
     */
    public function handle(CustomerPhoneBound $event)
    {
        $customer = $event->customer;
        // 查看是否已经发放过新人红包
        $transferred = TransferLog::where([
            'customer_id' => $customer->id,
            'type' => self::TYPE
        ])->exists();

        // 新人红包只发放一次 如果已发放 则不需要在发放
        if (! $transferred) {
            $transferMoney = new TransferMoney($customer);
            $transferMoney->toBalance($this->randomMoney(), self::TYPE);
        }
    }

    /**
     * 随机发放金额(单位分)
     *
     * @return int
     */
    private function randomMoney() : int
    {
        $money = [
            0.88, 1.88, 2.88, 3.88, 4.88, 5.88, 6.88, 7.88, 8.88
        ];

        return intval(Arr::random($money) * 100);
    }
}
