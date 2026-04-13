<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FreshBytes | Market Home</title>
    <link rel="icon" type="image/png" href="/images/logos-12-12.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Freeman&family=Inter:wght@400;500;600;700&family=Montserrat:wght@500;600;700&family=Open+Sans:wght@400;600;700;800&family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/categories-toggle.js'])
</head>

<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] min-h-screen antialiased">

    @php
        $productImages = [
            'Eggplant' => 'https://images.unsplash.com/photo-1518735869015-566a18eae4be?auto=format&fit=crop&w=640&q=80',
            'Lettuce' => 'https://images.unsplash.com/photo-1622205313162-be1d5712a43f?auto=format&fit=crop&w=640&q=80',
            'Squash' => 'https://images.unsplash.com/photo-1604977042946-1eecc30f269e?auto=format&fit=crop&w=640&q=80',
            'Watermelon' => 'https://images.unsplash.com/photo-1563114773-84221bd62daa?auto=format&fit=crop&w=640&q=80',
            'Apple' => 'https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?auto=format&fit=crop&w=640&q=80',
            'Carrot' => 'https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?auto=format&fit=crop&w=640&q=80',
            'Pechay' => 'https://images.unsplash.com/photo-1618040996337-56904b7850b9?auto=format&fit=crop&w=640&q=80',
        ];

        $categoryImages = [
            'Leafy Greens' => '/images/LeafyGreens_NOBG.png',
            'Root Vegetables' => '/images/RootVeg_NOBG.png',
            'Tropical Fruits' => '/images/TropicalFruits_NOBG.png',
            'Berries' => '/images/BERRIES_NOBG.png',
        ];

        $cards = $products->take(8);
        $recommendedCards = ($recommendedProducts ?? collect())->take(8);
        if ($recommendedCards->isEmpty()) {
            $recommendedCards = $products->take(8);
        }
    @endphp



    <nav class="site-nav">
        <div class="nav-container">

        <!-- ☰ MENU -->

        <div class="market-topbar">
            <!-- BRAND -->
            <a href="{{ route('market.home') }}" class="market-brand" aria-label="FreshBytes Home">
                <img src="/images/FreshBytes_FinalNewLogoWhite.png" alt="FreshBytes logo">
                <span>FreshBytes</span>
            </a>

            <form class="market-search" action="{{ route('market.home') }}" method="get">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path
                        d="M10.5 3a7.5 7.5 0 015.96 12.06l4.24 4.24-1.4 1.4-4.24-4.24A7.5 7.5 0 1110.5 3zm0 2a5.5 5.5 0 100 11 5.5 5.5 0 000-11z" />
                </svg>
                <input type="text" name="q" placeholder="Search products">
            </form>

            <div class="market-actions">
                <a href="#nutritional-products" aria-label="Nutrition">
                    <svg viewBox="0 0 24 24">
                        <path
                            d="M6 2h9a3 3 0 013 3v15a2 2 0 01-2 2H6a3 3 0 01-3-3V5a3 3 0 013-3zm0 2a1 1 0 00-1 1v14a1 1 0 001 1h10V5a1 1 0 00-1-1H6z" />
                    </svg>
                    <span>Nutrition</span>
                </a>
                <a href="#recommended-bites" aria-label="Notifications">
                    <svg viewBox="0 0 24 24">
                        <path
                            d="M12 2a6 6 0 016 6v3.59l1.7 2.54A1 1 0 0118.87 16H5.13a1 1 0 01-.83-1.87L6 11.59V8a6 6 0 016-6zm0 20a3 3 0 002.83-2h-5.66A3 3 0 0012 22z" />
                    </svg>
                    <span>Notifications</span>
                </a>
                <a href="#fresh-near-you" aria-label="Wishlist">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 21s-7-4.35-7-10a4 4 0 017-2.65A4 4 0 0119 11c0 5.65-7 10-7 10z" />
                    </svg>
                    <span>Wish. list</span>
                </a>
                <a href="{{ route('cart.index') }}" aria-label="Cart">
                    <svg viewBox="0 0 24 24">
                        <path
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1 5h12M9 20a1 1 0 102 0 1 1 0 00-2 0zm8 0a1 1 0 102 0 1 1 0 00-2 0z" />
                    </svg>
                    <span>Cart</span>
                </a>
                @auth
                    <form action="{{ route('auth.logout') }}" method="post" class="market-account-form">
                        @csrf
                        <button type="submit" aria-label="Logout">
                            <svg viewBox="0 0 24 24">
                                <path
                                    d="M10 3h7a2 2 0 012 2v14a2 2 0 01-2 2h-7v-2h7V5h-7V3zm-1 4l-1.41 1.41L10.17 11H3v2h7.17l-2.58 2.59L9 17l5-5-5-5z" />
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                @else
                    <a href="{{ route('auth.login') }}" aria-label="My Account">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 12a5 5 0 100-10 5 5 0 000 10zm0 2c-4.42 0-8 2.24-8 5v1h16v-1c0-2.76-3.58-5-8-5z" />
                        </svg>
                        <span>My Account</span>
                    </a>
                @endauth
            </div>
        </div>

        <div class="market-menubar">
            <details class="market-categories">
                <summary class="market-categories-btn" aria-label="All Categories">
                    <span>All Categories</span>
                    <svg viewBox="0 0 24 24">
                        <path d="M7 10l5 5 5-5z" />
                    </svg>
                </summary>
                <div class="market-categories-menu">
                    <a href="{{ route('market.home') }}">All Products</a>
                    @foreach($categories as $category)
                        <a
                            href="{{ route('market.home', ['category' => $category->category_id, 'q' => request('q')]) }}">{{ $category->category_name }}</a>
                    @endforeach
                </div>
            </details>
            <nav class="market-menu-links" aria-label="Primary">
                <a href="{{ route('market.home') }}">Home</a>
                <a href="#featured-categories">Categories</a>
                <a href="#fresh-near-you">Shop</a>
                <a href="#market-footer">Nutritional</a>
<a href="{{ route('seller.register') }}">Start Selling</a>
            </nav>

        </div>
        </div>
        </header>
        </div>
        </div>
    </nav>

    <main class="market-main">
        <section class="market-hero-card">
            <article class="market-hero-copy">
                <h1>Explore Latest</h1>
                <p>Most recent posts near you</p>
                <a href="#fresh-near-you">Explore</a>
            </article>
            <img src="/images/market_banner.png" alt="Fresh produce banner">
        </section>


        <section class="py-8 bg-white dark:bg-gray-900">
            <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0">
                <div class="market-section-head">
                    <h2>Featured Categories</h2>
                    <a href="#" class="js-toggle-categories" data-target="#all-categories-grid"
                        id="categories-toggle-btn">View all</a>
                </div>

                <div class="categories-grids-container">
                    <div id="featured-categories-grid" class="market-featured-grid">
                        @foreach(($featuredCategories ?? $categories ?? collect())->take(4) as $cat)
                            <article class="market-featured-card">
                                <a href="{{ route('market.home', ['category' => $cat->category_id]) }}">
                                    <img src="{{ $categoryImages[$cat->category_name] ?? '/images/market_banner.png' }}"
                                        alt="{{ $cat->category_name }}">
                                </a>
                                <h3>{{ strtoupper($cat->category_name) }}</h3>
                                <p>{{ $products->where('category_id', $cat->category_id)->count() }} Products</p>
                            </article>
                        @endforeach
                    </div>

                    <div id="all-categories-grid" class="market-featured-grid hidden">
                        @foreach($categories ?? collect() as $cat)
                            <article class="market-featured-card">
                                <a href="{{ route('market.home', ['category' => $cat->category_id]) }}">
                                    <img src="{{ $categoryImages[$cat->category_name] ?? '/images/market_banner.png' }}"
                                        alt="{{ $cat->category_name }}">
                                </a>
                                <h3>{{ strtoupper($cat->category_name) }}</h3>
                                <p>{{ $products->where('category_id', $cat->category_id)->count() }} Products</p>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="py-8 bg-white dark:bg-gray-900">
            <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0">
                <div class="market-section-head">
                    <h2>Fresh Bites Near You</h2>
                    <a href="#fresh-near-you">View all</a>
                </div>

                <div class="market-product-grid">
                    @foreach($cards as $product)
                        @php
                            $distance = number_format(($product->product_id % 4) + 1.4, 1);
                            $hoursAgo = ($product->product_id % 6) + 1;
                            $badge = $product->product_status === 'withered' ? 'Withered' : (($product->product_id % 3 === 0) ? 'Slightly Withered' : 'Fresh');
                            $img = $productImages[$product->product_name] ?? 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=640&q=80';
                        @endphp
                        <article class="market-product-card">
                            <a href="{{ route('product.show', $product->product_id) }}" class="market-product-thumb">
                                <img src="{{ $img }}" alt="{{ $product->product_name }}">
                            </a>
                            <button class="market-wish-btn" type="button" aria-label="Add to wishlist">
                                <svg viewBox="0 0 24 24">
                                    <path d="M12 21s-7-4.35-7-10a4 4 0 017-2.65A4 4 0 0119 11c0 5.65-7 10-7 10z" />
                                </svg>
                            </button>

                            <p class="market-product-title">{{ $product->product_name }}</p>
                            <p class="market-product-price">₱{{ number_format($product->product_price, 2) }} /
                                {{ $product->product_unit ?? 'kg' }}
                            </p>
                            <p class="market-product-meta">{{ $product->sell_count ?? 0 }} sold</p>
                            <p class="market-product-meta">{{ $distance }} km away</p>
                            <p class="market-product-meta">{{ $hoursAgo }} hours ago</p>
                            <p class="market-product-loc">{{ $product->product_location }}</p>
                            <div class="market-product-foot">
                                <span
                                    class="market-badge {{ $badge === 'Withered' ? 'warn' : ($badge === 'Slightly Withered' ? 'mid' : 'ok') }}">{{ $badge }}</span>
                                <span class="market-verified">Verified</span>
                            </div>
                            <form action="{{ route('cart.add', $product->product_id) }}" method="post"
                                class="market-cart-form">
                                @csrf
                                <button type="submit" class="market-cart-btn">Add to cart</button>
                            </form>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="market-section" id="recommended-bites">
            <div class="market-section-head">
                <h2>Recommended Bites For You</h2>
                <a href="#recommended-bites">View all</a>
            </div>

            <div class="market-product-grid">
                @foreach($recommendedCards as $product)
                    @php
                        $distance = number_format(($product->product_id % 4) + 1.4, 1);
                        $hoursAgo = ($product->product_id % 6) + 1;
                        $badge = $product->product_status === 'withered' ? 'Withered' : (($product->product_id % 3 === 0) ? 'Slightly Withered' : 'Fresh');
                        $img = $productImages[$product->product_name] ?? 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=640&q=80';
                    @endphp
                    <article class="market-product-card">
                        <a href="{{ route('product.show', $product->product_id) }}" class="market-product-thumb">
                            <img src="{{ $img }}" alt="{{ $product->product_name }}">
                        </a>
                        <button class="market-wish-btn" type="button" aria-label="Add to wishlist">
                            <svg viewBox="0 0 24 24">
                                <path d="M12 21s-7-4.35-7-10a4 4 0 017-2.65A4 4 0 0119 11c0 5.65-7 10-7 10z" />
                            </svg>
                        </button>

                        <p class="market-product-title">{{ $product->product_name }}</p>
                        <p class="market-product-price">₱{{ number_format($product->product_price, 2) }} /
                            {{ $product->product_unit ?? 'kg' }}
                        </p>
                        <p class="market-product-meta">{{ $product->sell_count ?? 0 }} sold</p>
                        <p class="market-product-meta">{{ $distance }} km away</p>
                        <p class="market-product-meta">{{ $hoursAgo }} hours ago</p>
                        <p class="market-product-loc">{{ $product->product_location }}</p>
                        <div class="market-product-foot">
                            <span
                                class="market-badge {{ $badge === 'Withered' ? 'warn' : ($badge === 'Slightly Withered' ? 'mid' : 'ok') }}">{{ $badge }}</span>
                            <span class="market-verified">Verified</span>
                        </div>
                        <form action="{{ route('cart.add', $product->product_id) }}" method="post" class="market-cart-form">
                            @csrf
                            <button type="submit" class="market-cart-btn">Add to cart</button>
                        </form>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="market-section market-articles" id="nutritional-products">
            <div class="market-section-head">
                <h2>Nutritional Products</h2>
                <a href="#nutritional-products">View all</a>
            </div>

            <div class="market-article-grid">
                @foreach(['/images/nutritional_1.png', '/images/nutritional_2.png', '/images/nutritional_3.png', '/images/nutritional_4.png'] as $img)
                    <article class="market-article-card">
                        <img src="{{ $img }}" alt="Healthy nutritional article">
                        <div class="market-article-body">
                            <p class="market-article-meta">Author <span>Sep 30, 2022</span></p>
                            <h3>Healthy vegetables salad to try</h3>
                            <p>This refreshing and nutrient-packed salad combines vibrant vegetables, hearty chickpeas,
                                and
                                a zesty lemon-olive oil dressing. Perfect for a light lunch or a side dish, loaded with
                                fiber, protein, and healthy fats.</p>
                            <a href="#fresh-near-you">Read More</a>
                        </div>
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