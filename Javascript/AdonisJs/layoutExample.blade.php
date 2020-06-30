//adding css from public file
{{ style('css/style.css') }}




//parent-layout

@include('partials.navbar')
<div class="container">

    @!section('content')
</div>

//child-layout

@layout('layouts.app')

@section('content')
    <h1>Login page..</h1>
@endsection


//link inside html with name route

<li><a href="{{ route('register') }}">Register</a></li>
<li><a href="{{ route('login') }}">Login</a></li>

