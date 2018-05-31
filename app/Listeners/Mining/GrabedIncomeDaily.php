<?php

namespace App\Listeners\Mining;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use DB;
use App\TransactionType;
use App\Transaction;

class GrabedIncomeDaily
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

        DB::beginTransaction();

            $receiver    = $mining->user()->first();
            
            $income      = $mining->mining_income;
            $type        = 'daily_income';
            $description = TransactionType::LIST[$type];
            $notes       = $type;
            $recever_id  = $receiver->id;
            $sender_id   = 0;
            $creator_id  = 0;
            
            Transaction::create([
                'amount'        => $income,
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
