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
