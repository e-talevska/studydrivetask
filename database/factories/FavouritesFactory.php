<?php

use Faker\Generator as Faker;

$factory->define(App\Favourite::class, function (Faker $faker) {
    return [
        'image_id' => rand(1, 5000),
        'user_id' => factory(App\User::class)->create()->id,
        'created_at' => $faker->dateTimeBetween('-1 month')
    ];
});
