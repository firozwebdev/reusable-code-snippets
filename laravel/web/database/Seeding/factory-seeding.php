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


$factory->define(\App\Models\Product::class, function (Faker $faker) {
    $image1 = $faker->randomElement(['/demo/1.jpg','/demo/2.jpg','/demo/7.jpg']);
    $image2 = $faker->randomElement(['/demo/2.jpg','/demo/7.jpg','/demo/3.jpg']);
    $image3 = $faker->randomElement(['/demo/3.jpg','/demo/6.jpg','/demo/1.jpg']);
    $image4 = $faker->randomElement(['/demo/4.jpg','/demo/3.jpg','/demo/2.jpg']);
    $image5 = $faker->randomElement(['/demo/5.jpg','/demo/1.jpg','/demo/3.jpg']);
    $image6 = $faker->randomElement(['/demo/6.jpg','/demo/3.jpg','/demo/4.jpg']);
    return [
        'product_name' => $faker->name,
        'product_title' => $faker->text,
        'category_id' => \App\Models\Category::all()->random()->id,
        'type' => $faker->randomElement(['Regular','Featured','Special']),
        'slug' => Str::slug($faker->firstName),
        'product_price' => $faker->numberBetween(100,1000),
        'special_price' => $faker->numberBetween(100,1000)-50,
        'start_date' => \Carbon\Carbon::now(),
        'end_date' => \Carbon\Carbon::now(),
        'product_quantity' => $faker->numberBetween(5,50),
        'sku' => Str::random(4),
        'stock' => $faker->numberBetween(5,50),
        'multiple' => json_encode([$image1,$image2,$image3,$image4,$image5,$image6]),
        'description' => 'চীনের সঙ্গে লাদাখে সং দুই দেশের মধ্যে বিরোধপূর্ণ সীমান্ত এলাকায় গোলাগুলি ও বিস্ফোরকের ব্যবহার নিষিদ্ধ করা হয় ওই চুক্তিতে।',
        'color' => json_encode(['yellow','Black']),
        'video_link' => 'https://www.youtube.com/watch?v=E2wa0BTHRMs',
        'warranty' => $faker->numberBetween(1,3),
        'status' => '1',
    ];
});