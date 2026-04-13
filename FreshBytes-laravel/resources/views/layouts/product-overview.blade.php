<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FreshBytes | {{ $product->product_name }}</title>
    <link rel="icon" type="image/png" href="/images/logos-12-12.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Freeman&family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@400;600;700;800&family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="market-page-body market-subpage-body">
    @php
        $catalog = config('market_catalog');
        $productProfiles = $catalog['products'] ?? [];
        $fallbackProfile = $catalog['fallback'] ?? [];

        $nameKey = strtolower(trim((string) $product->product_name));
        $matchedProfile = $productProfiles[$nameKey] ?? null;

        if (!$matchedProfile) {
            foreach ($productProfiles as $name => $profile) {
                if (str_contains($nameKey, $name) || str_contains($name, $nameKey)) {
                    $matchedProfile = $profile;
                    break;
                }
            }
        }

        $profile = $matchedProfile ?? $fallbackProfile;
        $productImage = $profile['image'];
        $rating = $product->top_rated ? 4.9 : 4.7;
        $sold = max(12, (int) ($product->sell_count ?? 0));

        $dummyReviews = [
            ['name' => 'Mia G.', 'score' => 5, 'text' => 'Very fresh and crisp. Delivery was fast and packaging was neat.'],
            ['name' => 'Jon P.', 'score' => 5, 'text' => 'Great quality and fair price. Will order again next week.'],
            ['name' => 'Aira L.', 'score' => 4, 'text' => 'Good produce, looked exactly like the listing photos.'],
            ['name' => 'Renz T.', 'score' => 5, 'text' => 'Seller is responsive and item arrived in excellent condition.'],
            ['name' => 'Kate B.', 'score' => 4, 'text' => 'Fresh item and reasonable delivery fee. Recommended.'],
        ];
    @endphp

    <div class="market-page-wrap">
        @include('layouts.market-navbar')

        <main class="market-main market-subpage-main">
            <section class="market-product-detail-card">
                <a href="{{ route('market.home') }}" class="market-back-btn" aria-label="Back">&larr;</a>

                <div class="market-product-main">
                    <div class="market-product-photo-wrap">
                        <img src="{{ $productImage }}" alt="{{ $product->product_name }}">
                    </div>

                    <div class="market-product-main-info">
                        <h1>{{ $product->product_name }}</h1>
                        <p class="market-product-seller">{{ $profile['location'] ?? $product->product_location }}</p>
                        <p class="market-product-price-big">&#8369;{{ number_format((float) $product->product_price, 2) }} each</p>

                        <div class="market-product-rating-row">
                            <span class="market-stars">&#9733;&#9733;&#9733;&#9733;&#9734;</span>
                            <strong>{{ number_format($rating, 1) }}/5</strong>
                            <span>{{ count($dummyReviews) + 54 }} reviews</span>
                        </div>

                        <p class="market-product-distance">229.4 km away</p>

                        <div class="market-product-side-meta">
                            <span>{{ $sold }} sold</span>
                            <button type="button" aria-label="Share">&#8599;</button>
                            <button type="button" aria-label="Add to wishlist">&#9825;</button>
                        </div>

                        <div class="market-detail-cart-row">
                            <form action="{{ route('cart.add', $product->product_id) }}" method="post" class="market-detail-cart-form">
                                @csrf
                                <input type="hidden" name="return_anchor" value="fresh-near-you">
                                <button type="submit" class="market-detail-cart-btn">Add to cart</button>
                            </form>
                            <a href="{{ route('market.nutrition.value', \Illuminate\Support\Str::slug($product->product_name)) }}" class="market-detail-nutrition-link">View Nutrition</a>
                        </div>
                    </div>
                </div>

                <section class="market-product-desc">
                    <h2>Description</h2>
                    <p>{{ $profile['detail'] }}</p>
                    <p class="market-product-nutrition-copy">{{ $profile['nutrition'] ?? 'Includes essential nutrients ideal for daily Filipino meals.' }}</p>
                </section>

                <section class="market-product-reviews">
                    <div class="market-product-reviews-head">
                        <h2>Buyer Reviews</h2>
                        <span>({{ count($dummyReviews) + 54 }})</span>
                    </div>

                    <div class="market-reviews-strip">
                        @foreach($dummyReviews as $review)
                            <article>
                                <h3>{{ $review['name'] }}</h3>
                                <p class="score">Score: {{ $review['score'] }}/5</p>
                                <p>{{ $review['text'] }}</p>
                            </article>
                        @endforeach
                    </div>
                </section>
            </section>
        </main>

        <div class="market-shared-footer" id="market-footer">
            @include('layouts.footer')
        </div>
    </div>
</body>

</html>
