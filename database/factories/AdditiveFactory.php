<?php

use Faker\Generator as Faker;
use App\Additive;

$factory->define(Additive::class, function (Faker $faker) {
    return [
        'name' => $faker->text(10),
        'price' => rand(20, 80)
    ];
});
