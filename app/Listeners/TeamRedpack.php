<?php

namespace App\Listeners;

use App\Events\CustomerInvitationCompleted;
use App\Models\Customer;
use App\Services\Wechat\TransferMoney;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Filesystem\Cache;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class TeamRedpack implements ShouldQueue
{
    private const TYPE = 'team';

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
        $customerId = $event->shareOrder->customer_id;

        Cache::tags('team')->lock($customerId)->get(function () use ($customerId) {
            Cache::tags('team')->increment($customerId);
            $total = Cache::tags('team')->get($customerId);
            Log::info("编号 {$customerId}, 邀请人数 {$total}");

            // 发放团队红包
            if ($total % 8 == 0) {
                $transferMoney = new TransferMoney(Customer::find($customerId));
                $transferMoney->toBalance(800, self::TYPE);
            } else if ($total % 6 == 0) {
                $transferMoney = new TransferMoney(Customer::find($customerId));
                $transferMoney->toBalance(600, self::TYPE);
            }
        });
    }
}
