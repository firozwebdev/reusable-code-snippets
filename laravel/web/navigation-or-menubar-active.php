<?php

$prefix = Request::route()->getPrefix();
$route = Route::current()->getName();


//sidebar link will be like below for active or menu-open class

{{ ($prefix == '/products') ? 'menu-open':''}} // checking by prefix generally for parent menu
{{ ($route == 'products.create') ? 'active':''}} // checking by route generally for child menu

{{ request()->is('/dashboard') ? ' active' : '' }} // checking by url





/*
    checking route  exists or not

*/

@if (Route::has('register'))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
    </li>
@endif



/*
    checking link in view page for different role with guard name

*/

//  চেক করা হচ্ছে ইউজার  আডমিন কিনা
if (Auth::guard('admin')->check()) {
    return redirect(RouteServiceProvider::ADMIN_HOME); 
}

//  চেক করা হচ্ছে ইউজার  ম্যানেজার কিনা
if (Auth::guard('manager')->check()) {
    return redirect(RouteServiceProvider::MANAGER_HOME); // for manager home page
}

//  চেক করা হচ্ছে ইউজার  লগিন করেছে কিনা
if(Auth::check()) {
    return redirect(RouteServiceProvider::HOME); // for Admin user page
}

Auth::user(); //it will provide an object of  User (who is logged in)
Auth::user()->id;
Auth::user()->email;

