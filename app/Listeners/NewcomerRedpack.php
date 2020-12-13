<?php

namespace App\Listeners;

use App\Events\CustomerPhoneBound;
use App\Models\TransferLog;
use App\Services\Wechat\TransferMoney;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewcomerRedpack implements ShouldQueue
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
        ])->whereNotNull('payment_no')->exists();

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
        $randomNumber = mt_rand(1, 1000);

        if ($randomNumber >=1 && $randomNumber <=800)  {
            $money = 0.88;
        } else if ($randomNumber >= 801 && $randomNumber <= 880) {
            $money = 1.88;
        } else if ($randomNumber >= 881 && $randomNumber <= 930) {
            $money = 2.88;
        } else if ($randomNumber >= 931 && $randomNumber <= 960) {
            $money = 3.88;
        } else if ($randomNumber >= 961 && $randomNumber <= 980) {
            $money = 4.88;
        } else if ($randomNumber >= 981 && $randomNumber <= 990) {
            $money = 5.88;
        } else if ($randomNumber >= 991 && $randomNumber <= 997) {
            $money = 6.88;
        } else if ($randomNumber >= 998 && $randomNumber <= 999) {
            $money = 7.88;
        } else {
            $money = 8.88;
        }

        return intval($money * 100);
    }
}
