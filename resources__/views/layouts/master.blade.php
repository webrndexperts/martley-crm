<!DOCTYPE html>
<html lang="en">
    @include('includes.head')

    <body class="nav-md">
        <div class="loader"></div>

        <div class="container body">
            <div class="main_container">
                @include('includes.sidebar')

                <!-- top navigation -->
                @include('includes.header')
                <!-- /top navigation -->

                <div class="right_col" role="main">
                    @yield('content')
                </div>

                <!-- footer content -->
                @include('includes.footer')
                <!-- /footer content -->
            </div>
        </div>
        @include('includes.scripts')
        <script>
            $(window).load(function() {
                $(".loader").fadeOut("slow");
            })
        </script>
    </body>
</html>