<!DOCTYPE html>
<html>
<head>

    <title>Ваш сайт</title>
    {{--    @vite(['resources/css/style.css'])--}}
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
{{--@include('product.layouts.header')--}}

<main>
    <div class="nav">
        @include('product.layouts.navigation')
    </div>
    <div class="content">
        @include('product.layouts.header')
        @yield('content')
    </div>
</main>
<script src="{{asset('js/jquery.min.js')}}"></script>
@yield('javascript')
</body>
</html>
