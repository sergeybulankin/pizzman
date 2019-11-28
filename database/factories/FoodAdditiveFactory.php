<?php

use Faker\Generator as Faker;
use App\FoodAdditive;

$factory->define(FoodAdditive::class, function (Faker $faker) {
    return [
        'food_id' => rand(1, 10),
        'additive_id' => rand(2, 5)
    ];
});
