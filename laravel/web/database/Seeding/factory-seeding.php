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

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
    ];
});

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
        'quantity' => $faker->numberBetween(1,10),
        'status' => $faker->randomElement([Product::AVAILABLE_PRODUCT,Product::UNAVAILABLE_PRODUCT]), // this constant defined in Product model
        'image' => $faker->randomElement(['1.jpg','2.jpg','3.jpg']),
        'seller_id' => User::all()->random()->id,
    ];
});

$factory->define(Transaction::class, function (Faker $faker) {

    $seller = Seller::has('products')->get()->random();
    $buyer = User::all()->except($seller->id)->random();
    return [
        
        'quantity' => $faker->numberBetween(1,3),
        'buyer_id' => $buyer->id,
        'product_id' => $seller->products->random()->id,
    ];
});