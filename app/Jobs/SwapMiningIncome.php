<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Mining;
use Log;

class SwapMiningIncome implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mining;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Mining $mining)
    {
        $this->mining = $mining;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('asdasd');
        // foreach( $minings as $item ) {
        //     echo 'runing';
        // }
    }
}
