<!doctype html>
<html class="no-js" lang="">
    <head>
        <title>@yield('title')</title>
        <link href="{{ asset('fontawesome/css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="page-wrapper">
            <h2>@yield('header')</h2>
            <div class="page-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        Найдены ошибки в форме
                    </div>
                @endif
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        {{ $message }}
                    </div>
                @endif

                @yield('content')
            </div>
        </div>

    </body>
</html>
