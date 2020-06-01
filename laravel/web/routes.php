<?php

/*
   if we want to different file inside route.php , then we have to follow the below line 
*/

Route::prefix('admin')->group(base_path('routes/admin.php')); 