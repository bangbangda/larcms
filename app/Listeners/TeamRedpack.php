<?php

namespace App\Listeners;

use App\Events\CustomerInvitationCompleted;
use App\Models\Customer;
use App\Models\GroupRedPacket;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
            if ($total % 8 == 0 || str_contains($total, '8')) {
                // 记录裂变红包数据
                GroupRedPacket::create([
                    'bill_no' => Str::random(),
                    'openid' => Customer::find($customerId)->mp_openid,
                    'total_amount' => 888,
                    'total_num' => 8,
                ]);
            }
        });
    }
}
