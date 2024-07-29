<?php

namespace Eduard\Account\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class HistoryCustomerUuid
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var string
     */
    public $ip;

    /**
     * @var string
     */
    public $customerUuid;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($ip, $customerUuid)
    {
        $this->ip = $ip;
        $this->customerUuid = $customerUuid;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        //return new PrivateChannel('channel-name');
        return [];
    }
}