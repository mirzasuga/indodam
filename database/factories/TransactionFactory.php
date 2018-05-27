<?php

use App\Transaction;
use App\User;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
        'amount'      => 100,
        'type'        => 'top_up',
        'sender_id'   => 0,
        'receiver_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});
