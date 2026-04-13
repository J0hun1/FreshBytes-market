<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>All Categories | FreshBytes</title>
    <link rel="icon" type="image/png" href="/images/logos-12-12.png">
    @vite(['resources/css/app.css'])
</head>
<body class="market-page-body" style="font-family:'Outfit',sans-serif;">
    @php
        $resolveCategoryImage = function ($categoryName) {
            $name = strtolower(trim($categoryName));

            return match (true) {
                str_contains($name, 'leaf') || str_contains($name, 'green') => '/images/LeafyGreens_NOBG.png',
                str_contains($name, 'root') || str_contains($name, 'vegetable') => '/images/RootVeg_NOBG.png',
                str_contains($name, 'tropical') || str_contains($name, 'fruit') => '/images/TropicalFruits_NOBG.png',
                str_contains($name, 'berr') => '/images/BERRIES_NOBG.png',
                default => '/images/market_banner.png',
            };
        };
    @endphp

    @include('layouts.market-navbar')

    <main class="market-main" style="max-width:1300px;margin:18px auto 36px;padding:24px;">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;">
            <h1 style="margin:0;color:#fff;font-size:52px;">All Categories</h1>
            <a href="{{ route('market.home') }}" style="text-decoration:none;background:#9ee19e;color:#043522;border-radius:10px;padding:10px 16px;font-weight:700;">Back to Market</a>
        </div>

        <section style="margin-top:18px;" class="market-featured-grid">
            @foreach($categories as $cat)
                <article class="market-featured-card">
                    <a href="{{ route('market.home', ['category' => $cat->category_id]) }}">
                        <img src="{{ $resolveCategoryImage($cat->category_name) }}" alt="{{ $cat->category_name }}">
                    </a>
                    <h3>{{ strtoupper($cat->category_name) }}</h3>
                    <p>{{ $products->where('category_id', $cat->category_id)->count() }} Products</p>
                </article>
            @endforeach
        </section>
    </main>

    @include('layouts.footer')
</body>
</html>
