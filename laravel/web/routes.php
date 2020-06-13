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



/*
 * organized routes
 */

Route::group(['prefix'=>'admin'],function (){
    Route::resource('managers', 'ManagerController');

    Route::group(['namespace'=>'Admin'], function(){

        Route::group(['middleware'=>'auth:admin'],function (){
            Route::resource('managers', 'ManagerController');
            Route::post('logout','AdminLoginController@logout')->name('admin.logout');
        });

        Route::group(['as'=>'admin.','namespace'=>'Auth'],function (){
            Route::get('/login', 'LoginController@showLoginForm')->name('login');
            Route::post('/login','LoginController@login')->name('login');

        });

    });

});