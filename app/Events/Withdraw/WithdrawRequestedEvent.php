<?php

namespace App\Events\Withdraw;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\WithdrawRequest;
use App\User;

class WithdrawRequestedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $withdrawRequest, $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(
        User $user,
        WithdrawRequest $withdrawRequest
    ) {

        $this->user = $user;
        $this->withdrawRequest = $withdrawRequest;

    }
}
