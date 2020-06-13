<?php

/*
 * Relationship query many to many
 */

$product = new Product;
$product->title = 'Cap';
$product->price = 50;
$product->save();
// category_id and product_id are set in pivot table
// using belongsToMany relationship
$category = Category::find(3);
$product->categories()->attach($category);





/*
 * normal query
 */
$category = Category::whereIn('title', ['Food', 'Fashion'])->get();