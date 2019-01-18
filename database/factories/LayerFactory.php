<?php

use Faker\Generator as Faker;

$factory->define(App\Layer::class, function (Faker $faker) {
    return [
        'name' => ucwords($faker->company),
        'description' => join(' ', $faker->paragraphs)
    ];
});
