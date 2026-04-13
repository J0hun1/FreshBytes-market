@php
    $navCategories = \App\Models\Category::where('category_isActive', true)->orderBy('category_name')->get();
@endphp

<nav class="market-header">
    <div class="nav-container">
        <div class="market-topbar">
            <a href="{{ route('market.home') }}" class="market-brand" aria-label="FreshBytes Home">
                <img src="/images/FreshBytes_FinalNewLogoWhite.png" alt="FreshBytes logo">
                <span>FreshBytes</span>
            </a>

            <form class="market-search" action="{{ route('market.home') }}" method="get">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M10.5 3a7.5 7.5 0 015.96 12.06l4.24 4.24-1.4 1.4-4.24-4.24A7.5 7.5 0 1110.5 3zm0 2a5.5 5.5 0 100 11 5.5 5.5 0 000-11z" />
                </svg>
                <input type="text" name="q" placeholder="Search products">
            </form>

            <div class="market-actions">
                <a href="{{ route('market.home') }}#nutritional-products" aria-label="Nutrition">
                    <img src="/images/market_topButtons_nutriotional.png" alt="Nutrition">
                    <span>Nutrition</span>
                </a>
                <a href="{{ route('market.home') }}#recommended-bites" aria-label="Notifications">
                    <img src="/images/market_topButtons_notifs.png" alt="Notifications">
                    <span>Notifications</span>
                </a>
                <a href="{{ route('market.home') }}#fresh-near-you" aria-label="Wishlist">
                    <img src="/images/market_topButtons_wishlist.png" alt="Wishlist">
                    <span>Wish. list</span>
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
                    <svg viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z" /></svg>
                </summary>
                <div class="market-categories-menu">
                    <a href="{{ route('market.categories') }}">View all categories</a>
                    @foreach($navCategories as $category)
                        <a href="{{ route('market.home', ['category' => $category->category_id]) }}">{{ $category->category_name }}</a>
                    @endforeach
                </div>
            </details>
            <nav class="market-menu-links" aria-label="Primary">
                <a href="{{ route('market.home') }}">Home</a>
                <a href="{{ route('market.categories') }}">Categories</a>
                <a href="{{ route('market.products.nearby') }}">Shop</a>
                <a href="{{ route('market.home') }}#nutritional-products">Nutritional</a>
                <a href="{{ route('seller.register') }}">Start Selling</a>
            </nav>
        </div>
    </div>
</nav>
