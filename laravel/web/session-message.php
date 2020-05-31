<?php

// Success Session message

@if(Session::get('message'))
    <div class="alert alert-success">
        {{ Session::get('message') }}
    </div>
    {{ Session::put('message','') }}
@endif


// Error Session message

@if(Session::get('error'))
    <div class="alert alert-danger">
        {{ Session::get('error') }}
    </div>
    {{ Session::put('error','') }}
@endif