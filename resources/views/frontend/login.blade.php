<!doctype html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <title>Login | REDD+ Kalimantan Barat</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Login Portal Resmi REDD+ Kalimantan Barat">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" href="{{ asset('backend_template/images/favicon.ico') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('frontend/css/app.css') }}">
    </head>

    <body>
        <div class="auth-page">
            <section class="auth-page__brand" aria-label="REDD+ Kalimantan Barat">
                <div class="brand-panel">
                    <div class="brand-panel__logos" aria-label="Logo Pemerintah Provinsi Kalimantan Barat, Republik Indonesia, dan REDD+ Kalbar">
                        <img
                            src="{{ asset('frontend/images/logo-pemprov-kalbar.webp') }}"
                            alt="Provinsi Kalimantan Barat"
                            class="brand-panel__crest"
                        >

                        <img
                            src="{{ asset('frontend/images/indonesia-logo.png') }}"
                            alt="Bhinneka Tunggal Ika"
                            class="brand-panel__indonesia"
                        >

                        <img
                            src="{{ asset('frontend/images/redd-plus-kalbar.png') }}"
                            alt="REDD+ Kalbar"
                            class="brand-panel__redd-logo"
                        >
                    </div>

                    <h1>Selamat Datang !</h1>
                    <p>PORTAL RESMI REDD+ KALIMANTAN BARAT</p>
                </div>
            </section>

            <section class="auth-page__content" aria-label="Form login">
                <header class="auth-header">
                    <a class="auth-header__brand" href="{{ url('/') }}" aria-label="REDD+ Kalimantan Barat">
                        <img src="{{ asset('frontend/images/redd-plus-kalbar.png') }}" alt="" class="auth-header__crest">
                        <span>REDD+ Kalbar</span>
                    </a>
                </header>

                <main class="auth-page__main">
                    <section class="login-card" aria-labelledby="login-title">
                        <div class="login-card__heading">
                            <span class="login-card__icon" aria-hidden="true">
                                <svg viewBox="0 0 28 28" focusable="false">
                                    <path d="M14 13.5a6.5 6.5 0 1 0 0-13 6.5 6.5 0 0 0 0 13Z"></path>
                                    <path d="M3 21.4c0-4.2 4.4-6.6 11-6.6s11 2.4 11 6.6c0 3.9-4 6.1-11 6.1S3 25.3 3 21.4Z"></path>
                                </svg>
                            </span>
                            <div>
                                <h2 id="login-title">Login</h2>
                                <p>Silahkan login untuk akses lanjut</p>
                            </div>
                        </div>

                        @if (session('failed'))
                            <div class="alert alert--danger" role="alert">{{ session('failed') }}</div>
                        @endif

                        <form class="login-form" action="{{ route('login-process') }}" method="POST">
                            @csrf

                            <label class="sr-only" for="email">Username</label>
                            <input
                                class="form-control @error('email') form-control--error @enderror"
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                placeholder="Username"
                                autocomplete="username"
                                required
                                autofocus
                            >
                            @error('email')
                                <small class="field-error">{{ $message }}</small>
                            @enderror

                            <label class="sr-only" for="password">Password</label>
                            <div class="password-field">
                                <input
                                    class="form-control @error('password') form-control--error @enderror"
                                    id="password"
                                    name="password"
                                    type="password"
                                    placeholder="Password"
                                    autocomplete="current-password"
                                    required
                                >
                                <button class="password-field__toggle" type="button" aria-label="Tampilkan password" aria-pressed="false">
                                    <svg viewBox="0 0 24 24" focusable="false" aria-hidden="true">
                                        <path d="M12 5c5.4 0 9.3 4.3 10.5 6.1.3.5.3 1.3 0 1.8C21.3 14.7 17.4 19 12 19S2.7 14.7 1.5 12.9a1.7 1.7 0 0 1 0-1.8C2.7 9.3 6.6 5 12 5Zm0 3.7a3.3 3.3 0 1 0 0 6.6 3.3 3.3 0 0 0 0-6.6Zm0 1.8a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"></path>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <small class="field-error">{{ $message }}</small>
                            @enderror

                            <button class="button button--primary" type="submit">Login</button>
                        </form>
                    </section>
                </main>

                <footer class="auth-footer">
                    <span>Portal Resmi REDD+ Kalimantan Barat</span>
                </footer>
            </section>
        </div>

        <script src="{{ asset('frontend/js/app.js') }}"></script>
    </body>
</html>
