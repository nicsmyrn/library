<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard - Σελίδα Διαχείρισης</title>

    <link href="/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <link href="/css/dashboard.css" rel="stylesheet">
</head>

<body>
    <div id="wrapper">
        @include('admin.partials.nav')
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">@yield('header')</h1>
                </div>
            </div>
            @yield('content')
        </div>
        <pre>
            @{{ $data | json }}
        </pre>
    </div>

    <script src="{!! url('js/all.js') !!}"></script>
    <script src="    {!! url('js/dashboard.js') !!}"></script>

     <script src="https://js.pusher.com/2.2/pusher.min.js"></script>
     <script src="{!! url('js/vendor.js') !!}"></script>
     <script src="{!! url('js/vue_notifications.js') !!}"></script>
    @yield('scripts.footer')
    @include('flash')
</body>

</html>
