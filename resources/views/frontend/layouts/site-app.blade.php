<!doctype html>
<html lang="id">
    @include('frontend.layouts.site-head')

    <body>
        @yield('body')
        @include('frontend.layouts.lsm-modal')
        @include('frontend.layouts.agenda-modal')
        @include('frontend.layouts.media-modal')
        @stack('scripts')
    </body>
</html>
