

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