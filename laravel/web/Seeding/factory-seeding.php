<?php


$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'first_name' => $faker->firstName(),
        'last_name' => $faker->lastName(),
        'category_id' => App\Category::all()->random()->id,
        'title' => $faker->lastName(),
        'price' =>  $faker->numberBetween(10,100),
        'type' => $faker->randomElement(['Regular','Featured','Special']),
        'description' => $faker->text,
        
    ];
});

