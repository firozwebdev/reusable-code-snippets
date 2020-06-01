<?php

$prefix = Request::route()->getPrefix();
$route = Route::current()->getName();


//sidebar link will be like below for active or menu-open class

{{ ($prefix == '/products') ? 'menu-open':''}} // generally for parent menu
{{ ($route == 'products.create') ? 'active':''}} // generally for child menu