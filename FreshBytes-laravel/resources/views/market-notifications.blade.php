<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FreshBytes | Notifications</title>
    <link rel="icon" type="image/png" href="/images/logos-12-12.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Freeman&family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@400;600;700;800&family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="market-page-body market-subpage-body">
    <div class="market-page-wrap">
        @include('layouts.market-navbar')

        <main class="market-main market-subpage-main">
            <section class="market-subpage-shell">
                <h1 class="market-subpage-title">Notifications</h1>

                <form class="market-sub-search" method="get" action="{{ route('market.notifications') }}">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path
                            d="M10.5 3a7.5 7.5 0 015.96 12.06l4.24 4.24-1.4 1.4-4.24-4.24A7.5 7.5 0 1110.5 3zm0 2a5.5 5.5 0 100 11 5.5 5.5 0 000-11z" />
                    </svg>
                    <input type="text" name="q" placeholder="Search notifications">
                </form>

                <div class="market-notification-list-page">
                    @foreach($notifications as $notification)
                        <article class="market-notification-row {{ $notification['highlight'] ? 'highlight' : 'muted' }}">
                            <div class="market-notification-icon {{ $notification['icon'] }}"></div>
                            <div>
                                <h3>{{ $notification['title'] }}</h3>
                                <p>{{ $notification['message'] }}</p>
                            </div>
                            <span>{{ $notification['time'] }}</span>
                        </article>
                    @endforeach
                </div>
            </section>
        </main>

        <div class="market-shared-footer" id="market-footer">
            @include('layouts.footer')
        </div>
    </div>
</body>

</html>
