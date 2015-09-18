<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/css/all.css">
    <link rel="stylesheet" href="/css/app.css">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.0/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    @yield('links.header')
    <title>@yield('title')</title>
    @yield('scripts.header')
</head>

<body>
    @include('partials.nav')
    <div class="container">
        @yield('content')
    </div>

    <script src="/js/all.js"></script>
    {{--<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.0/js/bootstrap-toggle.min.js"></script>--}}

    <div class="flash-box">
        Updated!
    </div>
    @yield('scripts.footer')
    @yield('footer')
    @include('flash')
    @include('auth._modal')

</body>

</html>