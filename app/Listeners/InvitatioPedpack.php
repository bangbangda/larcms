<?php

namespace App\Listeners;

use App\Events\CustomerInvitationCompleted;
use App\Models\Customer;
use App\Models\ShareOrder;
use App\Services\Wechat\TransferMoney;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class InvitatioPedpack implements ShouldQueue
{
    private const TYPE = 'basis';

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
     * @param  CustomerInvitationCompleted  $event
     * @return void
     */
    public function handle(CustomerInvitationCompleted $event)
    {
        $shareOrder = $event->shareOrder;
        // 有上级时 向上级发放佣金
        if ($this->isSend($shareOrder)) {

            $customer = Customer::find($shareOrder->customer_id);

            $transferMoney = new TransferMoney($customer);
            $transferMoney->toBalance($this->getMoney(), self::TYPE);
        }
    }

    /**
     * 获取红包金额
     *
     * @return int
     */
    private function getMoney() : int
    {
        $randomNumber = mt_rand(1, 1000);

        if ($randomNumber >= 1 && $randomNumber <= 500)  {
            $money = 0.88;
        } else if ($randomNumber >= 501 && $randomNumber <= 900) {
            $money = 1.88;
        } else if ($randomNumber >= 901 && $randomNumber <= 1000) {
            $money = 2.88;
        } else {
            $money = 3.88;
        }

        return intval($money * 100);
    }


    /**
     * @param  ShareOrder  $shareOrder
     * @return bool
     */
    private function isSend(ShareOrder $shareOrder) : bool
    {
        return $shareOrder->pay_state === 0;
    }
}
