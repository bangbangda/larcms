<?php

namespace App\Listeners;

use App\Events\CustomerInvitationCompleted;
use App\Models\Customer;
use App\Models\RedpackSetting;
use App\Services\Wechat\TransferMoney;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class InvitatioPedpack
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

        $customer = Customer::find($shareOrder->customer_id);

        $transferMoney = new TransferMoney($customer);
        $transferMoney->toBalance($this->getMoney(), self::TYPE);
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
}
