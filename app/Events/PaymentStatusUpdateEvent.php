<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentStatusUpdateEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $clientEmail;
    public $status;
    /**
     * Create a new event instance.
     *
     * @param $clientEmail
     * @param $Status
     */
    public function __construct($clientEmail,$Status)
    {
        $this->clientEmail=$clientEmail;
        $this->status=$Status;
    }
}
