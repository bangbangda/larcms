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

            $customer = Customer::find($customer->parent_id);

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
        // 用户有上级
        if (! is_null($customer->parent_id)) {
            $shareOrder = ShareOrder::where([
                'customer_id' => $customer->parent_id,
                'sub_openid' => $customer->openid,
                'pay_state' => 0
            ])->count();

            if ($shareOrder === 1) {
                return true;
            }
        }
        Log::error('用户编号：' . $customer->parent_id . ' 不符合发放条件条件');
        return false;
    }
}
