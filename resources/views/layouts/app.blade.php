<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

        <!-- Scripts -->
        <!-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) -->

        <!-- CSS -->
        @include('includes.css')

    </head>
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">

                @include('includes.sidebar')

                @include('includes.header')

                <div class="right_col" role="main">
                    @yield('content')
                </div>

                <!-- footer content -->
                @include('includes.footer')
                <!-- /footer content -->

            </div>
        </div>
        
        @include('includes.scripts')
    </body>
</html>
