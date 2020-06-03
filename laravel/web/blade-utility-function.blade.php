

@php

@endphp



/*
    comma will not be seen for last item in side a loop

*/

@foreach($categories as $category)
    {{ $category->name }}
    @if(! $loop->last) 
        ,
    @endif
@endforeach

