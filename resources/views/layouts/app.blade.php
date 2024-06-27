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
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

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
