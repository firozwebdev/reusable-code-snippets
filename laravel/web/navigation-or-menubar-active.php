<?php

$prefix = Request::route()->getPrefix();
$route = Route::current()->getName();


//sidebar link will be like below for active or menu-open class

{{ ($prefix == '/products') ? 'menu-open':''}} // generally for parent menu
{{ ($route == 'products.create') ? 'active':''}} // generally for child menu





/*
    checking route  exists or not

*/

@if (Route::has('register'))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
    </li>
@endif