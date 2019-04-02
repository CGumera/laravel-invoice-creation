<?php

use Faker\Generator as Faker;
use App\Product;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 10000)
    ];
});
