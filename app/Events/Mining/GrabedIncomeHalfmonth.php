<?php

namespace App\Events\Mining;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\Mining;
use App\User;

class GrabedIncomeHalfmonth
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $mining, $user, $amount;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Mining $mining, User $user, $amount)
    {
        $this->mining = $mining;
        $this->user = $user;
        $this->amount = $amount;
    }

    // /**
    //  * Get the channels the event should broadcast on.
    //  *
    //  * @return \Illuminate\Broadcasting\Channel|array
    //  */
    // public function broadcastOn()
    // {
    //     return new PrivateChannel('channel-name');
    // }
}
