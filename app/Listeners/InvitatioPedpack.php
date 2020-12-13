<?php

namespace App\Listeners;

use App\Events\CustomerPhoneBound;
use App\Models\Customer;
use App\Models\RedpackSetting;
use App\Models\ShareOrder;
use App\Services\Wechat\TransferMoney;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
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
     * @param  CustomerPhoneBound  $event
     * @return void
     */
    public function handle(CustomerPhoneBound $event)
    {
        $customer = $event->customer;
        // 有上级时 向上级发放佣金
        if ($this->isSend($customer)) {

            $shareOrder = ShareOrder::where([
                'sub_openid' => $customer->openid
            ])->first();

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
        $setting = RedpackSetting::type(self::TYPE)->active()->first();

        return $setting['amount'] * 100;
    }


    /**
     * @param  Customer  $customer
     * @return bool
     */
    private function isSend(Customer $customer) : bool
    {
        return ShareOrder::where([
            'sub_openid' => $customer->openid,
            'pay_state' => 0
        ])->exists();

    }
}
