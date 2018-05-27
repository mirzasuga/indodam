<?php

use App\Package;
use App\User;
use Faker\Generator as Faker;

$factory->define(Package::class, function (Faker $faker) {

    return [
        'name'           => $faker->word,
        'description'    => $faker->sentence,
        'price'          => 1000000,
        'wallet'         => 200,
        'system_portion' => 200,
        'creator_id'     => function () {
            return factory(User::class)->create()->id;
        },
    ];
});
