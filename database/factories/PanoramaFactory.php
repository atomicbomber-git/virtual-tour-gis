<?php

use Faker\Generator as Faker;

$factory->define(App\Panorama::class, function (Faker $faker) {
    return [
        'name' => $faker->unique->randomNumber,
    ];
});
