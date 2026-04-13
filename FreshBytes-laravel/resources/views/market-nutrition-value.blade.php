<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FreshBytes | Nutritional Value</title>
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
            <section class="market-value-card">
                <a href="{{ route('market.nutrition.profile') }}" class="market-back-btn" aria-label="Back">&#8592;</a>

                <div class="market-value-header">
                    <img src="{{ $profile['image'] }}" alt="{{ $profile['name'] }} nutritional image">

                    <div class="market-value-content">
                        <h1>{{ $profile['name'] }}</h1>
                        <p class="market-value-type">{{ $profile['type'] }}</p>

                        <div class="market-value-chips">
                            @foreach($profile['chips'] as $chip)
                                <span>{{ $chip }}</span>
                            @endforeach
                        </div>

                        <p class="market-value-description">{{ $profile['description'] }}</p>

                        <h2>Nutrition Facts</h2>
                        <p class="market-value-subtitle">Amount Per 100 grams</p>

                        <div class="market-value-stats">
                            @foreach($profile['stats'] as $stat)
                                <article>
                                    <strong>{{ $stat['value'] }}</strong>
                                    <span>{{ $stat['label'] }}</span>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="market-value-table">
                    <p>% Daily Value*</p>
                    @foreach($profile['facts'] as $fact)
                        <div>
                            <span>
                                <strong>{{ $fact['name'] }}</strong> {{ $fact['value'] }}
                            </span>
                            <span>{{ $fact['dv'] }}</span>
                        </div>
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
