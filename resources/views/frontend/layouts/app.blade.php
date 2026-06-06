<!doctype html>
<html lang="id">
    @include('frontend.layouts.head')

    <body>
        <div class="auth-page">
            <section class="auth-page__brand" aria-label="REDD+ Kalimantan Barat">
                @yield('brand')
            </section>

            <section class="auth-page__content" aria-label="@yield('content_label', 'Konten halaman')">
                @include('frontend.layouts.header')

                <main class="auth-page__main">
                    @yield('content')
                </main>

                @include('frontend.layouts.footer')
            </section>
        </div>

        <script src="{{ asset('frontend/js/app.js') }}"></script>
        @stack('scripts')
    </body>
</html>
