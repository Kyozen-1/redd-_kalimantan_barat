<!DOCTYPE html>
<html lang="en">
    @include('auth.login.layouts.head')


    <body class="authentication-bg">

        @yield('content')
        <!-- end page -->
        @include('auth.login.layouts.js')
    </body>
</html>
