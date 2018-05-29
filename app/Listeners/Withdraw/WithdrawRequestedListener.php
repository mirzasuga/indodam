<?php

namespace App\Listeners\Withdraw;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Support\Facades\Mail;

use App\Mail\Withdraws\RequestedMail as WithdrawRequestedMail;

class WithdrawRequestedListener
{
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {

        $withdrawRequest = $event->withdrawRequest;
        $user = $event->user;

        Mail::to( $user->email )
        ->send( new WithdrawRequestedMail( $withdrawRequest, $user ) );
        
    }
}
