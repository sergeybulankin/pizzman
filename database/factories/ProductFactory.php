<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'product_title' => $faker->name,
        'category_id' => rand(1, 4),
        'product_description' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'price' => rand(150, 450),
    ];
});
