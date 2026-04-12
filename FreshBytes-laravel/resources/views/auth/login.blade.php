<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | FreshBytes</title>
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
                    <span>FreshBytes</span>
                </a>

                <h1>Hi There!</h1>
                <p>Welcome back to FreshBytes</p>

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
                        <span>Log in with Google</span>
                    </button>
                </form>

                <div class="auth-divider"><span>or</span></div>

                <form action="{{ route('auth.login.submit') }}" method="post" class="auth-form">
                    @csrf
                    <label>
                        <span class="sr-only">Email</span>
                        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                    </label>

                    <label>
                        <span class="sr-only">Password</span>
                        <input type="password" name="password" placeholder="Password" required>
                    </label>

                    <div class="auth-row">
                        <label class="remember-wrap">
                            <input type="checkbox" name="remember" value="1">
                            <span>Remember me</span>
                        </label>
                        <a href="{{ route('auth.forgot-password') }}" class="text-link">Forgot password?</a>
                    </div>

                    <button type="submit" class="auth-primary-btn">Log In</button>
                </form>

                <p class="auth-footer-link">Don't have an account? <a href="{{ route('auth.signup') }}">Sign up</a></p>
            </div>

            <aside class="auth-right">
                <img src="/images/auth/login-fruits.png" alt="Fresh vegetables and fruits">
            </aside>
        </section>
    </main>
</body>
</html>
