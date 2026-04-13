<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FreshBytes | Nutrition Profile</title>
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
                <h1 class="market-subpage-title">Nutritional Profile</h1>

                <div class="market-nutrition-shell">
                    <form class="market-sub-search" method="get" action="{{ route('market.nutrition.profile') }}">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path
                                d="M10.5 3a7.5 7.5 0 015.96 12.06l4.24 4.24-1.4 1.4-4.24-4.24A7.5 7.5 0 1110.5 3zm0 2a5.5 5.5 0 100 11 5.5 5.5 0 000-11z" />
                        </svg>
                        <input type="text" name="q" value="{{ $search }}" placeholder="Search">
                    </form>

                    <p class="market-nutrition-meta"><span>8 favorites</span><span>9 restricted</span></p>

                    <div class="market-nutrition-top-tiles">
                        @foreach($topTiles as $tile)
                            <article>
                                <span class="market-tile-icon {{ $tile['tile'] }}" aria-hidden="true"></span>
                                <p>{{ $tile['label'] }}</p>
                            </article>
                        @endforeach
                    </div>

                    <h2>128 Available Products</h2>

                    <div class="market-nutrition-grid-wrap">
                        <div class="market-nutrition-groups">
                            @forelse($groups as $letter => $items)
                                <section>
                                    <h3>{{ $letter }}</h3>
                                    <div>
                                        @foreach($items as $item)
                                            <a href="{{ route('market.nutrition.value', \Illuminate\Support\Str::slug($item)) }}">{{ $item }}</a>
                                        @endforeach
                                    </div>
                                </section>
                            @empty
                                <p class="market-empty-note">No produce found for your search.</p>
                            @endforelse
                        </div>

                        <aside class="market-alphabet-side">
                            @foreach(range('A', 'Z') as $letter)
                                <span>{{ $letter }}</span>
                            @endforeach
                        </aside>
                    </div>
                </div>
            </section>
        </main>

        <div class="market-shared-footer" id="market-footer">
            @include('layouts.footer')
        </div>
    </div>
</body>

</html>
