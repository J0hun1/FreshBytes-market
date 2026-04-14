<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} | FreshBytes</title>
    <link rel="icon" type="image/png" href="/images/logos-12-12.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Freeman&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="market-page-body" style="font-family:'Outfit',sans-serif;">
    @php
        $catalog = config('market_catalog');
        $productProfiles = $catalog['products'] ?? [];
        $fallbackProfile = $catalog['fallback'] ?? [];

        $resolveProductProfile = function ($productName) use ($productProfiles, $fallbackProfile) {
            $normalized = strtolower(trim((string) $productName));
            if (isset($productProfiles[$normalized])) {
                return $productProfiles[$normalized];
            }

            foreach ($productProfiles as $name => $profile) {
                if (str_contains($normalized, $name) || str_contains($name, $normalized)) {
                    return $profile;
                }
            }

            return $fallbackProfile;
        };
    @endphp
    @include('layouts.market-navbar')

    <main class="market-main market-subpage-main">
        <section class="market-subpage-shell market-list-shell">
            <div class="market-page-head-row">
                <h1 class="market-subpage-title">{{ $title }}</h1>
                <a href="{{ route('market.home') }}" class="market-back-link">Back to Market</a>
            </div>

            <p class="market-page-summary">Locally sourced fruits and vegetables from Philippine farms, curated for freshness and daily cooking.</p>

            <section style="margin-top:18px;" class="market-product-grid">
                @foreach($products as $product)
                    @php
                        $profile = $resolveProductProfile($product->product_name);
                        $img = $product->image_url;
                    @endphp
                    <article class="market-product-card">
                        <a href="{{ route('product.show', $product->product_id) }}" class="market-product-thumb">
                            <img src="{{ $img }}" alt="{{ $product->product_name }}">
                        </a>
                        <div class="market-product-details">
                            <p class="market-product-title">{{ $product->product_name }}</p>
                            <p class="market-product-price">₱{{ number_format($product->product_price, 2) }} / {{ $product->product_unit ?? 'kg' }}</p>
                            <p class="market-product-meta">{{ $product->sell_count ?? 0 }} sold</p>
                            <p class="market-product-loc"><span>{{ $profile['location'] ?? $product->product_location }}</span></p>
                            <form action="{{ route('cart.add', $product->product_id) }}" method="post" class="market-cart-form">
                                @csrf
                                <input type="hidden" name="return_anchor" value="fresh-near-you">
                                <button type="submit" class="market-cart-btn">Add to cart</button>
                            </form>
                        </div>
                    </article>
                @endforeach
            </section>
        </section>
    </main>

    @include('layouts.footer')
</body>
</html>
