<?php


$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName(),
        'title' => $faker->lastName(),
        'price' =>  $faker->numberBetween(10,100),
        'type' => $faker->randomElement(['Regular','Featured','Special']),
        
    ];
});
