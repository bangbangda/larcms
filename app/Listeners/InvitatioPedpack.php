<?php

namespace App\Listeners;

use App\Events\CustomerInvitationCompleted;
use App\Models\Customer;
use App\Models\RedpackSetting;
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
//        $setting = RedpackSetting::type(self::TYPE)->active()->first();

        return intval(Arr::random([0.88, 1.88, 2.88]) * 100);
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
