<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up | FreshBytes</title>
    <link rel="icon" type="image/png" href="/images/logos-12-12.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="auth-page">
    <main class="auth-shell">
        <section class="auth-grid">
            <div class="auth-left">
                <a href="{{ url('/') }}" class="auth-brand" aria-label="Go to homepage">
                    <img src="/images/FreshBytes_FinalNewLogoWhite.png" alt="FreshBytes logo">
                    <span class="freshbytes-word">FreshBytes</span>
                </a>

                <h1>Get Started</h1>
                <p>Create your account now</p>

                @if (session('status'))
                    <div class="auth-flash success">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    <div class="auth-flash error">{{ $errors->first() }}</div>
                @endif

                <form action="{{ route('auth.google') }}" method="post" class="auth-google-form">
                    @csrf
                    <button type="submit" class="google-btn">
                        <img src="/images/auth/Google__G__logo.svg" alt="Google logo">
                        <span>Continue with Google</span>
                    </button>
                </form>

                <div class="auth-divider"><span>or</span></div>

                <form action="{{ route('auth.signup.submit') }}" method="post" class="auth-form">
                    @csrf
                    <label>
                        <span class="sr-only">Username</span>
                        <input type="text" name="username" placeholder="Username" value="{{ old('username') }}" required>
                    </label>

                    <label>
                        <span class="sr-only">Email</span>
                        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                    </label>

                    <label>
                        <span class="sr-only">Password</span>
                        <input type="password" name="password" placeholder="Password" required>
                    </label>

                    <label>
                        <span class="sr-only">Confirm Password</span>
                        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                    </label>

                    <div class="auth-row auth-row-end">
                        <a href="{{ route('auth.forgot-password') }}" class="text-link">Forgot password?</a>
                    </div>

                    <button type="submit" class="auth-primary-btn">Sign Up</button>
                </form>

                <p class="auth-footer-link">Have an account? <a href="{{ route('auth.login') }}">Log in</a></p>
            </div>

            <aside class="auth-right signup-poster">
                <img src="/images/auth/signup-fruits.png" alt="Fresh produce basket">
            </aside>
        </section>
    </main>
</body>
</html>
