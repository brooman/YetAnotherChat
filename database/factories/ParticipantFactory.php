<?php

use Faker\Generator as Faker;
use App\User;

$factory->define(App\Participant::class, function (Faker $faker) {
    return [
        'channel_id' => 1,
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});
