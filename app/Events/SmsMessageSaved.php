<?php

namespace App\Events;

use App\Models\SmsSendMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SmsMessageSaved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public SmsSendMessage $smsMessage;

    /**
     * Create a new event instance.
     *
     * @param  SmsSendMessage  $smsSendMessage
     */
    public function __construct(SmsSendMessage $smsSendMessage)
    {
        $this->smsMessage = $smsSendMessage;
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
