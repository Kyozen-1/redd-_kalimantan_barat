<!doctype html>
<html lang="id">
    @include('frontend.layouts.site-head')

    <body>
        @yield('body')
        @stack('scripts')
    </body>
</html>
