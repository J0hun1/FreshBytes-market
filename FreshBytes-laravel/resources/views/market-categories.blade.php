<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>All Categories | FreshBytes</title>
    <link rel="icon" type="image/png" href="/images/logos-12-12.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Freeman&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="market-page-body" style="font-family:'Outfit',sans-serif;">
    @php
        $catalog = config('market_catalog');
        $categoryPhotos = $catalog['category_photos'] ?? [];
        $categoryKeywordMap = $catalog['category_keyword_map'] ?? [];

        $resolveCategoryImage = function ($categoryName) use ($categoryPhotos, $categoryKeywordMap) {
            $name = strtolower(trim((string) $categoryName));

            if (isset($categoryPhotos[$name])) {
                return $categoryPhotos[$name];
            }

            foreach ($categoryKeywordMap as $needle => $mappedKey) {
                if (str_contains($name, $needle) && isset($categoryPhotos[$mappedKey])) {
                    return $categoryPhotos[$mappedKey];
                }
            }

            return '/images/market_banner.png';
        };
    @endphp

    @include('layouts.market-navbar')

    <main class="market-main market-subpage-main">
        <section class="market-subpage-shell market-list-shell">
            <div class="market-page-head-row">
                <h1 class="market-subpage-title">All Categories</h1>
                <a href="{{ route('market.home') }}" class="market-back-link">Back to Market</a>
            </div>

            <p class="market-page-summary">Browse real Philippine produce categories sourced from local growers and farming cooperatives.</p>

            <section style="margin-top:18px;" class="market-featured-grid">
                @foreach($categories as $cat)
                    <article class="market-featured-card">
                        <a href="{{ route('market.home', ['category' => $cat->category_id]) }}">
                            <img src="{{ $resolveCategoryImage($cat->category_name) }}" alt="{{ $cat->category_name }}">
                        </a>
                        <h3 class="market-category-name">{{ strtoupper($cat->category_name) }}</h3>
                        <p class="market-detail-text">{{ $cat->category_description }}</p>
                        <p class="market-detail-text">{{ $products->where('category_id', $cat->category_id)->count() }} Products</p>
                    </article>
                @endforeach
            </section>
        </section>
    </main>

    @include('layouts.footer')
</body>
</html>
