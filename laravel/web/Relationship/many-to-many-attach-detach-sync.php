<?php


/*
 *  attach, detach, sync, syncWithoutDetaching for many to many relationship -- tested project name 'fw'
 */

// pivot table named 'role_user'
$table->id();
$table->foreignId('user_id');
$table->foreignId('role_id');
$table->string('name');
$table->timestamps();

$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
$table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');


 //User.php (Model)

public function roles(){
    return $this->belongsToMany(Role::class);
}


 // Role.php (Model)

public function users(){
    return $this->belongsToMany(User::class);
}



Route::get('/', function () {
    $user = App\User::first();
    $roles = App\Role::all();

    $user->roles()->attach($roles); // attach can duplicate role for one user
    $user->roles()->attach([1,3]);

    /*
     * But sync method will work same way as attach but not make duplicate,
     * suppose if a user has no role, it work just like attach method means it will attach role on that user.
     * but if that user has previous role then first detach that role and attach new role means make no duplicate.
     */
    $user->roles()->sync([1,2]);
    /*
     * But if any user has one role and we want to assign new role with previous role then
     * sync method will not work because it will delete previous role and assign new role,
     * for this reason we have to use syncWithoutDetaching method. it will keep previous role and
     * make new one besides. and also make no duplicate.
     */
    $user->roles()->syncWithoutDetaching([1,2,3]); // sync method make roles on user but first delete previous role of that user But syncWithoutDetaching method will work same way but not make duplicate
    //$user->roles()->detach($role);

});



 // normally timestamp of pivot table not work that's why we have to change relation slightly in model


public function roles(){
    return $this->belongsToMany(Role::class)->withTimeStamps();
}


public function users(){
    return $this->belongsToMany(User::class)->withTimeStamps();
}


/*
 * How to add a field in pivot table and display  that field from pivot table
 */


// step-1 first add column in that pivot table 'role_user',  suppose coloumn  is 'name'

$table->id();
$table->foreignId('user_id');
$table->foreignId('role_id');
$table->string('name');
$table->timestamps();

$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
$table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

Route::get('/', function () {
    $user = App\User::first();
    $role = App\Role::find(1);



    $user->roles()->sync([     // here role is 1, and A user is assigned that role by 'Sabuz'
        $role->id => [
            'name' => 'Sabuz'
        ]
    ]);



    $user->roles()->sync([     // here role is 1, and A user is assigned that role by 'Sabuz'
        1 => [
            'name' => 'Sabuz'
        ]
    ]);


});


 // To get pivot data , we have to Change relation inside model

public function users(){
    return $this->belongsToMany(User::class)->withPivot(['name'])->withTimestamps();
}

public function roles(){
    return $this->belongsToMany(Role::class)->withPivot(['name'])->withTimestamps();
}

// then we will get pivot data

dd($user->roles->first()->pivot->name);
