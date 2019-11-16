<?php

use Faker\Generator as Faker;

$factory->define(\App\FoodType::class, function (Faker $faker) {
    return [
        'food_id' => rand(1, 10),
        'type_id' => rand(1, 3)
    ];
});
