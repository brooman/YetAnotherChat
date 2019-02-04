<?php

use App\Participant;
use App\User;
use Faker\Generator as Faker;

$factory->define(App\Message::class, function (Faker $faker) {
    return [
        'channel_id' => 1,
        'participant_id' => function () {
            $user = factory(User::class)->create();

            $participant = factory(Participant::class)->create([
                'channel_id' => 1,
                'user_id' => $user->id,
            ]);

            return $participant->id;
        },
        'content' => $faker->paragraph,
    ];
});
