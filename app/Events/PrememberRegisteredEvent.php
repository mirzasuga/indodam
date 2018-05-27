<?php

namespace App\Events;
use Illuminate\Queue\SerializesModels;
use App\Services\WalletService;
use App\User;

class PrememberRegisteredEvent
{
    use SerializesModels;

    public $premember;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $premember)
    {
        $this->premember = $premember;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    // public function broadcastOn()
    // {
    //     return new PrivateChannel('channel-name');
    // }
}
