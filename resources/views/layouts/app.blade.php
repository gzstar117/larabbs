<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{--CSRF Token--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'LaraBBS') - Laravel 进阶学习</title>

    {{--样式--}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app" class="{{ route_class() }}-page">

        @include('layouts._header')

        <div id="container">

            @yield('content')

        </div>

        @include('layouts._footer')

    </div>

    {{--引入js--}}
    <script src="{{ asset('js/app.js') }}"></script>

</body>
</html>