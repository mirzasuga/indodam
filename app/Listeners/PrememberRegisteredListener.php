<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

use App\Services\WalletService;

use App\Mail\RegisteredUser as MailRegisteredUser;

class PrememberRegisteredListener
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
        $premember = $event->premember;
        WalletService::initialize( $premember );
        Mail::to( $premember->email )
            ->send( new MailRegisteredUser( $premember ) );
    }
}
