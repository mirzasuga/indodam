<?php

namespace App\Mail\Withdraws;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;
use App\WithdrawRequest;

class RequestedMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $withdrawRequest;
    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(WithdrawRequest $withdrawRequest, User $user)
    {
        $this->withdrawRequest = $withdrawRequest;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $withdrawRequest = $this->withdrawRequest;

        $token      = $withdrawRequest->request_token;
        $verifyLink = route('withdraw.verify', ['request_token' => $token]);
        $ipAddress  = $withdrawRequest->sender_ip;
        $amount     = $withdrawRequest->amount;
        $user       = $this->user;
        $createdAt  = $withdrawRequest->created_at;

        return $this->markdown('mails.withdraw.requested')
            ->with([
                'verifyLink'=> $verifyLink,
                'amount'    => $amount,
                'ipAddress' => $ipAddress,
                'createdAt' => $createdAt,
                'user'      => $user,
            ]);
    }
}
