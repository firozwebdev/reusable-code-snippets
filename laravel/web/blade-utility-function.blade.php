

@php

@endphp


/*
    When we want to check an array is empty or not use normal empty($array)

*/

@if(!empty($array))
    //here array is not empty
@else
    //here array is  empty
@endif

//But in laravel, we found collection instead array though they are identically same, how to check array empty or not in laravel blade,
// here $results is a collection, normally laravel eloquent return collection, we have to use below function for collection instead above function

@if( !$results->isEmpty())
    //here collection is not empty
@else
    //here collection is  empty
@endif



@forelse($status->replies as $reply)
    <p>{{ $reply->body }}</p>
@empty
    <p>No replies</p>
@endforelse

/*
    comma will not be seen for last item in side a loop

*/

@foreach($categories as $category)
    {{ $category->name }}
    @if(! $loop->last) 
        ,
    @endif
@endforeach



/*
    Difference between section and push

*/

@extends('master')

...

@for ($i = 0; $i < 3; $i++)

    @push('test-push')
        <script type="text/javascript">
            // Push {{ $i }}
        </script>
    @endpush

@section('test-section')
    <script type="text/javascript">
        // Section {{ $i }}
    </script>
@endsection

@endfor


master.blade.php

@stack('test-push')
@yield('test-section')
</body>

result:

<script type="text/javascript">
    // Push 0
</script>
<script type="text/javascript">
    // Push 1
</script>
<script type="text/javascript">
    // Push 2
</script>
<script type="text/javascript">
    // Section 0
</script>
</body>

comment:
    Push is better than section for scripts and styles


<head>
    <!-- push target to head -->
    @stack('styles')
    @stack('scripts')
</head>

/*
    loop index or no. inside  foreach loop
*/
<td>{{ $loop->iteration }}</td> start from 1
<td>{{ $loop->index }}</td> start from 0
<td>{{ $loop->index + 1 }}</td> start from 1




@includeWhen(Auth::user(), 'nav.user')
@includeWhen(request()->is('/'), 'partials.jumbotron')


//Reference from https://laravel-news.com/five-useful-laravel-blade-directives

/*
    checking user is authenticated or not
*/
@if(auth()->user())
    // The user is authenticated.
@endif

//blade directive

@auth
    // The user is authenticated.
@endauth


/*
checking user is guest or not means not authenticated
*/
@if(auth()->guest())
    // The user is not authenticated.
@endif

//blade directive
@guest
    // The user is not authenticated.
@endguest


//blade directive

@guest
    // The user is not authenticated.
@else
    // The user is authenticated.
@endguest

/*
checking view is exist or not
*/

@if(view()->exists('first-view-name'))
    @include('first-view-name')
@else
    @include('second-view-name')
@endif

//same work as above

@includeFirst(['first-view-name', 'second-view-name']);



@if($post->hasComments())
    @include('posts.comments')
@endif

@includeWhen($post->hasComments(), 'posts.comments');


@if(view()->exists('view-name'))
    @include('view-name')
@endif

@includeIf('view-name')