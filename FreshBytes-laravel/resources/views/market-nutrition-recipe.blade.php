<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FreshBytes | {{ $recipe['title'] }}</title>
    <link rel="icon" type="image/png" href="/images/logos-12-12.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Freeman&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="market-page-body market-subpage-body">
    <div class="market-page-wrap">
        @include('layouts.market-navbar')

        <main class="market-main market-subpage-main">
            <section class="market-subpage-shell market-list-shell market-recipe-shell">
                <div class="market-page-head-row">
                    <h1 class="market-subpage-title">{{ $recipe['title'] }}</h1>
                    <a href="{{ route('market.home') }}#nutritional-products" class="market-back-link">Back to Nutritional</a>
                </div>

                <p class="market-page-summary">{{ $recipe['intro'] }}</p>

                <img src="{{ $recipe['image'] }}" alt="{{ $recipe['title'] }}" class="market-recipe-image">

                <article class="market-recipe-content">
                    <h2>How to Prepare</h2>
                    <p>{{ $recipe['content'] }}</p>
                </article>
            </section>
        </main>

        <div class="market-shared-footer" id="market-footer">
            @include('layouts.footer')
        </div>
    </div>
</body>

</html>
