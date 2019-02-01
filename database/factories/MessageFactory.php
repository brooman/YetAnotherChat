<?php

use Faker\Generator as Faker;
use App\Participant;
use App\User;

$factory->define(App\Message::class, function (Faker $faker) {
    return [
        'channel_id' => 1,
        'user_id' => function () {
            $user = factory(User::class)->create();
            factory(Participant::class)->create([
                'channel_id' => 1,
                'user_id' => $user->id,
                ]);

            return $user->id;
        },
        'content' => $faker->paragraph,
    ];
});
