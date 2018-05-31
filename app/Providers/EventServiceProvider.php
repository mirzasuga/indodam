<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Members\Registered' => [
            'App\Listeners\Members\RegisteredListener',
        ],
        'App\Events\PrememberRegisteredEvent' => [
            'App\Listeners\PrememberRegisteredListener'
        ],
        'App\Events\Withdraw\WithdrawRequestedEvent' => [
            'App\Listeners\Withdraw\WithdrawRequestedListener'
        ],

        /**
         * MINING EVENTS
         */
        'App\Events\Mining\GrabedIncomeDaily' => [
            'App\Listeners\Mining\GrabedIncomeDaily'
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
