<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Marketinglist;

class NewList implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $marketinglist;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Marketinglist $marketinglist)
    {
        $this->marketinglist = $marketinglist;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('NewList');
    }
}
