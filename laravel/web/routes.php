<?php

/*
   if we want to different file inside route.php , then we have to follow the below line 
*/

Route::prefix('admin')->group(base_path('routes/admin.php')); 


/*
   only and except used in resource route
*/


Route::resource('categories', 'Category\CategoryController',['except'=> ['create','edit']]);
Route::resource('products', 'Category\CategoryProductController',['only'=> ['index','update']]);