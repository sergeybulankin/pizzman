<?php

use Faker\Generator as Faker;
use App\PizzmanAddressFood;

$factory->define(PizzmanAddressFood::class, function (Faker $faker) {
    return [
        'pizzman_address_id' => rand(1, 2),
        'food_id' => rand(1, 10)
    ];
});
