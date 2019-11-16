<?php

use Faker\Generator as Faker;

$factory->define(App\Food::class, function (Faker $faker) {
    return [
        'category_id' => rand(1, 4),
        'name' => $faker->name,
        'structure' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'price' => rand(150, 450),
        'weight' => rand(150, 450),
        'calories' => rand(150, 450),
        'protein' => rand(150, 450),
        'fat' => rand(150, 450),
        'carbohydrates' => rand(150, 450),
        'image' => $faker->imageUrl(300, 300, 'food'),
        'note' => $faker->realText(10, 1),
        'recommend' => rand(0, 1),
        'visibility' => rand(0, 1)
    ];
});
