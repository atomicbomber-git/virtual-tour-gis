<?php

use Faker\Generator as Faker;

$factory->define(App\Location::class, function (Faker $faker) {
    return [
        'name' => ucwords($faker->company),
        'address' => $faker->streetAddress,
        'description' => $faker->paragraph,
        'latitude' => rand(-50, 50) / 1000 + -0.026330,
        'longitude' => rand(-50, 50) / 1000 + 109.342504,
    ];
});
