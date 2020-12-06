<?php

namespace App\Events;

use App\Models\ShareOrder;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CustomerInvitationCompleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public ShareOrder $shareOrder;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ShareOrder $shareOrder)
    {
        $this->shareOrder = $shareOrder;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
