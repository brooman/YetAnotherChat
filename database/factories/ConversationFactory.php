<?php

use Faker\Generator as Faker;

$factory->define(YetAnotherChat\Conversation::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
    ];
});
