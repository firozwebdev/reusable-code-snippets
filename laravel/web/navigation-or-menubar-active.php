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