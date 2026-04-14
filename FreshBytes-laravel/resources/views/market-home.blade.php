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

<body class="market-page-body">

    @php
        $catalog = config('market_catalog');
        $productProfiles = $catalog['products'] ?? [];
        $categoryPhotos = $catalog['category_photos'] ?? [];
        $categoryKeywordMap = $catalog['category_keyword_map'] ?? [];
        $fallbackProfile = $catalog['fallback'] ?? [];
        $recipes = $catalog['recipe_articles'] ?? [];

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

        $cards = $products->take(8);
        $recommendedCards = ($recommendedProducts ?? collect())->take(8);
        if ($recommendedCards->isEmpty()) {
            $recommendedCards = $products->take(8);
        }
    @endphp
    <div class="market-page-wrap">
    <nav class="market-header">
        <div class="nav-container">
        <div class="market-topbar">
            <!-- BRAND -->
            <a href="{{ route('market.home') }}" class="market-brand" aria-label="FreshBytes Home">
                <img src="/images/FreshBytes_FinalNewLogoWhite.png" alt="FreshBytes logo">
                <span class="freshbytes-word">FreshBytes</span>
            </a>

            <form class="market-search" action="{{ route('market.home') }}" method="get">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path
                        d="M10.5 3a7.5 7.5 0 015.96 12.06l4.24 4.24-1.4 1.4-4.24-4.24A7.5 7.5 0 1110.5 3zm0 2a5.5 5.5 0 100 11 5.5 5.5 0 000-11z" />
                </svg>
                <input type="text" name="q" placeholder="Search products">
            </form>

            <div class="market-actions">
                <a href="{{ route('market.nutrition.profile') }}" aria-label="Nutrition">
                    <img src="/images/market_topButtons_nutriotional.png" alt="Nutrition">
                    <span>Nutrition</span>
                </a>
                <div class="market-notif-wrap">
                    <button type="button" class="market-notif-trigger" aria-label="Notifications" aria-expanded="false" aria-controls="market-notif-dropdown">
                        <img src="/images/market_topButtons_notifs.png" alt="Notifications">
                        <span>Notifications</span>
                    </button>
                    <div class="market-notif-dropdown" id="market-notif-dropdown" hidden>
                        <span class="market-notif-pointer" aria-hidden="true"></span>
                        <div class="market-notif-head">
                            <h3>Notifications</h3>
                            <a href="{{ route('market.notifications') }}" class="market-notif-head-link">View all</a>
                        </div>
                        <div class="market-notif-list">
                            <article>
                                <h4>Freshness Alert</h4>
                                <p>Your banana is still fresh but nearing ripeness. Store in a cool and dry place.</p>
                            </article>
                            <article>
                                <h4>New Fresh Produce Available!</h4>
                                <p>Local farmers just stocked fresh tomatoes and lettuce. Order while supplies last.</p>
                            </article>
                            <article>
                                <h4>Boost Your Immunity!</h4>
                                <p>Fresh citrus fruits are packed with Vitamin C. Check recipes and meal plans now.</p>
                            </article>
                            <article>
                                <h4>Sustainability Tip</h4>
                                <p>Reduce food waste by storing vegetables properly. Learn more in our guide.</p>
                            </article>
                        </div>
                        <a href="{{ route('market.notifications') }}" class="market-notif-view-all">View all notifications</a>
                    </div>
                </div>
                <a href="#fresh-near-you" aria-label="Wishlist">
                    <img src="/images/market_topButtons_wishlist.png" alt="Wishlist">
                    <span>Wishlist</span>
                </a>
                <a href="{{ route('cart.index') }}" aria-label="Cart">
                    <img src="/images/market_topButtons_cart.png" alt="Cart">
                    <span>Cart</span>
                </a>
                @auth
                    <a href="{{ route('account.index') }}" aria-label="My Account">
                        <img src="/images/market_topButtons_myAcc.png" alt="My Account">
                        <span>My Account</span>
                    </a>
                @endauth
                @auth
                    <form action="{{ route('auth.logout') }}" method="post" class="market-account-form">
                        @csrf
                        <button type="submit" aria-label="Logout">
                            <svg class="market-logout-icon" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M10 3h7a2 2 0 012 2v14a2 2 0 01-2 2h-7v-2h7V5h-7V3zm-1 4l-1.41 1.41L10.17 11H3v2h7.17l-2.58 2.59L9 17l5-5-5-5z"/>
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                @else
                    <a href="{{ route('auth.login') }}" aria-label="My Account">
                        <img src="/images/market_topButtons_myAcc.png" alt="My Account">
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
                    <a href="{{ route('market.categories') }}">View all categories</a>
                    @foreach($categories as $category)
                        <a
                            href="{{ route('market.home', ['category' => $category->category_id, 'q' => request('q')]) }}">{{ $category->category_name }}</a>
                    @endforeach
                </div>
            </details>
            <nav class="market-menu-links" aria-label="Primary">
                <a href="{{ route('market.home') }}">Home</a>
                <a href="{{ route('market.categories') }}">Categories</a>
                <a href="#fresh-near-you">Shop</a>
                <a href="{{ route('market.home') }}#nutritional-products">Nutritional</a>
                <a href="{{ route('seller.register') }}">Start Selling</a>
            </nav>

        </div>
        </div>
    </nav>

    <main class="market-main">
        @if(session('success'))
            <div class="market-toast" id="market-toast" role="status" aria-live="polite">
                {{ session('success') }}
            </div>
        @endif

        <section class="market-hero-card">
            <article class="market-hero-copy">
                <h1>Explore Latest</h1>
                <p>Most recent posts near you</p>
                <a href="#fresh-near-you">Explore</a>
            </article>
            <img src="/images/market_banner.png" alt="Fresh produce banner">
        </section>


        <section class="market-section" id="all-categories">
            <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0">
                <div class="market-section-head">
                    <h2>Featured Categories</h2>
                    <a href="{{ route('market.categories') }}">View all</a>
                </div>

                <div class="categories-grids-container">
                    <div id="featured-categories-grid" class="market-featured-grid">
                        @foreach(($featuredCategories ?? $categories ?? collect())->take(4) as $cat)
                            <article class="market-featured-card">
                                <a href="{{ route('market.home', ['category' => $cat->category_id]) }}">
                                    <img src="{{ $resolveCategoryImage($cat->category_name) }}"
                                        alt="{{ $cat->category_name }}">
                                </a>
                                <h3 class="market-category-name">{{ strtoupper($cat->category_name) }}</h3>
                                <p class="market-detail-text">{{ $products->where('category_id', $cat->category_id)->count() }} Products</p>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="market-section" id="fresh-near-you">
            <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0">
                <div class="market-section-head">
                    <h2>Fresh Bites Near You</h2>
                    <a href="{{ route('market.products.nearby') }}">View all</a>
                </div>

                <div class="market-product-grid">
@foreach($cards as $product)
                        @php
                            $profile = $resolveProductProfile($product->product_name);
                            $distance = number_format(($product->product_id % 4) + 1.4, 1);
                            $hoursAgo = ($product->product_id % 6) + 1;
                            $badge = $product->product_status === 'withered' ? 'Withered' : (($product->product_id % 3 === 0) ? 'Slightly Withered' : 'Fresh');
                        @endphp
                        <article class="market-product-card">
                            <a href="{{ route('product.show', $product->product_id) }}" class="market-product-thumb">
                                <img src="{{ $product->image_url ?? 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $product->product_name }}">
                            </a>
                            <button class="market-wish-btn" type="button" aria-label="Add to wishlist">
                                <svg viewBox="0 0 24 24">
                                    <path d="M12 21s-7-4.35-7-10a4 4 0 017-2.65A4 4 0 0119 11c0 5.65-7 10-7 10z" />
                                </svg>
                            </button>

                            <div class="market-product-details">
                                <p class="market-product-title">{{ $product->product_name }}</p>
                                <p class="market-product-time">{{ $hoursAgo }} hours ago</p>
                                <p class="market-product-price">₱{{ number_format($product->product_price, 2) }} /
                                    {{ $product->product_unit ?? 'kg' }}
                                </p>
                                <p class="market-product-meta">{{ $product->sell_count ?? 0 }} sold</p>
                                <p class="market-product-meta">{{ $distance }} km away</p>
                                <p class="market-product-loc">
                                    <svg viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M12 2a7 7 0 00-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 00-7-7zm0 10a3 3 0 110-6 3 3 0 010 6z" />
                                    </svg>
                                    <span>{{ $profile['location'] ?? $product->product_location }}</span>
                                </p>
                                <div class="market-product-foot">
                                    <span
                                        class="market-badge {{ $badge === 'Withered' ? 'warn' : ($badge === 'Slightly Withered' ? 'mid' : 'ok') }}">{{ $badge }}</span>
                                    <span class="market-verified">Verified</span>
                                </div>
                                <form action="{{ route('cart.add', $product->product_id) }}" method="post"
                                    class="market-cart-form">
                                    @csrf
                                    <input type="hidden" name="return_anchor" value="fresh-near-you">
                                    <button type="submit" class="market-cart-btn">Add to cart</button>
                                </form>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="market-section" id="recommended-bites">
            <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0">
                <div class="market-section-head">
                    <h2>Recommended Bites For You</h2>
                    <a href="{{ route('market.products.popular') }}">View all</a>
                </div>

                <div class="market-product-grid">
@foreach($recommendedCards as $product)
                    @php
                        $profile = $resolveProductProfile($product->product_name);
                        $distance = number_format(($product->product_id % 4) + 1.4, 1);
                        $hoursAgo = ($product->product_id % 6) + 1;
                        $badge = $product->product_status === 'withered' ? 'Withered' : (($product->product_id % 3 === 0) ? 'Slightly Withered' : 'Fresh');
                    @endphp
                    <article class="market-product-card">
                        <a href="{{ route('product.show', $product->product_id) }}" class="market-product-thumb">
                            <img src="{{ $product->image_url ?? 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $product->product_name }}">
                        </a>
                        <button class="market-wish-btn" type="button" aria-label="Add to wishlist">
                            <svg viewBox="0 0 24 24">
                                <path d="M12 21s-7-4.35-7-10a4 4 0 017-2.65A4 4 0 0119 11c0 5.65-7 10-7 10z" />
                            </svg>
                        </button>

                        <div class="market-product-details">
                            <p class="market-product-title">{{ $product->product_name }}</p>
                            <p class="market-product-time">{{ $hoursAgo }} hours ago</p>
                            <p class="market-product-price">₱{{ number_format($product->product_price, 2) }} /
                                {{ $product->product_unit ?? 'kg' }}
                            </p>
                            <p class="market-product-meta">{{ $product->sell_count ?? 0 }} sold</p>
                            <p class="market-product-meta">{{ $distance }} km away</p>
                            <p class="market-product-loc">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M12 2a7 7 0 00-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 00-7-7zm0 10a3 3 0 110-6 3 3 0 010 6z" />
                                </svg>
                                <span>{{ $profile['location'] ?? $product->product_location }}</span>
                            </p>
                            <div class="market-product-foot">
                                <span
                                    class="market-badge {{ $badge === 'Withered' ? 'warn' : ($badge === 'Slightly Withered' ? 'mid' : 'ok') }}">{{ $badge }}</span>
                                <span class="market-verified">Verified</span>
                            </div>
                            <form action="{{ route('cart.add', $product->product_id) }}" method="post" class="market-cart-form">
                                @csrf
                                <input type="hidden" name="return_anchor" value="recommended-bites">
                                <button type="submit" class="market-cart-btn">Add to cart</button>
                            </form>
                        </div>
                    </article>
                @endforeach
                </div>
            </div>
        </section>

        <section class="market-section market-articles" id="nutritional-products">
            <div class="market-section-head">
                <h2>Nutritional Products</h2>
                <a href="{{ route('market.nutrition.profile') }}">View all</a>
            </div>

            <div class="market-article-grid">
                @foreach($recipes as $recipe)
                    <article class="market-article-card">
                        <img src="{{ $recipe['image'] }}" alt="{{ $recipe['title'] }} recipe image" onerror="this.onerror=null;this.src='/images/nutritional_1.png';">
                        <div class="market-article-body">
                            <p class="market-article-meta"><span class="freshbytes-word">FreshBytes</span> Recipe <span>Philippine Kitchen</span></p>
                            <h3>{{ $recipe['title'] }}</h3>
                            <p class="market-article-snippet">{{ \Illuminate\Support\Str::limit($recipe['intro'] ?? 'Healthy Filipino recipe made from fresh local produce.', 92) }}</p>
                            <a href="{{ route('market.nutrition.recipe', $recipe['slug']) }}">Read Recipe</a>
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

    @if(session('success'))
        <script>
            window.addEventListener('DOMContentLoaded', function () {
                const toast = document.getElementById('market-toast');
                if (!toast) return;
                setTimeout(() => {
                    toast.classList.add('is-hidden');
                }, 2600);
            });
        </script>
    @endif

    <script>
        window.addEventListener('DOMContentLoaded', function () {
            const trigger = document.querySelector('.market-notif-trigger');
            const dropdown = document.getElementById('market-notif-dropdown');

            if (!trigger || !dropdown) {
                return;
            }

            const closeDropdown = () => {
                dropdown.hidden = true;
                trigger.setAttribute('aria-expanded', 'false');
            };

            trigger.addEventListener('click', function (event) {
                event.stopPropagation();
                const shouldOpen = dropdown.hidden;
                dropdown.hidden = !shouldOpen;
                trigger.setAttribute('aria-expanded', shouldOpen ? 'true' : 'false');
            });

            dropdown.addEventListener('click', function (event) {
                event.stopPropagation();
            });

            document.addEventListener('click', closeDropdown);
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeDropdown();
                }
            });
        });
    </script>
</body>

</html>