<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'The Becoming Institute') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    <!-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) -->
      <link rel="preload" as="style" href="http://localhost/becoming-institute-crm/public/build/assets/app-D-sv12UV.css">
    <link rel="modulepreload" href="http://localhost/becoming-institute-crm/public/build/assets/app-BkDPDVeP.js">
    <link rel="stylesheet" href="http://localhost/becoming-institute-crm/public/build/assets/app-D-sv12UV.css">
    <script type="module" src="http://localhost/becoming-institute-crm/public/build/assets/app-BkDPDVeP.js"></script>
   

        <!-- Bootstrap -->
        <link href="{{ url('public/admin/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">

        <!-- Font Awesome -->

        <link href="{{ url('public/admin/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

        <!-- NProgress -->

        <link href="{{ url('public/admin/vendors/nprogress/nprogress.css') }}" rel="stylesheet">

        <!-- Animate.css -->

        <link href="{{ url('public/admin/vendors/animate.css/animate.min.css') }}" rel="stylesheet">

        <!-- Custom Theme Style -->

        <link href="{{ url('public/admin/build/css/custom.min.css') }}" rel="stylesheet">

        <link href="{{ url('public/css/style.css') }}" rel="stylesheet">

</head>

<style>
    .login{
        background: url("{{
        asset('images/login_background.jpg')
        }}") no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        }
</style>

<body class="login">
        <!-- <main class="py-4"> -->
            @yield('content')
        <!-- </main> -->
</body>
</html>