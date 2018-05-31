<?php

namespace App\Listeners\Mining;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Transaction;
use App\TransactionType;
use DB;
class GrabedIncomeHalfmonth
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
        $mining = $event->mining;
        $user = $event->user;
        $amount = $event->amount;

        DB::beginTransaction();
            
            
            $type        = 'half_monthly_income';
            $description = TransactionType::LIST[$type];
            $notes       = $type;
            $recever_id  = $user->id;
            $sender_id   = 0; //system
            $creator_id  = 0; //system
            
            Transaction::create([
                'amount'        => $amount,
                'type'          => $type,
                'receiver_id'   => $recever_id,
                'sender_id'     => $sender_id,
                'notes'         => $notes,
                'creator_id'    => $creator_id,
                'description'   => $description
            ]);

        DB::commit();
    }
}
