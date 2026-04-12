<nav class="site-nav">
    <div class="site-nav-inner">
        <button class="menu-square" type="button" aria-label="Open menu">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <a href="/" class="brand-wrap">
            <img class="brand-logo" src="/images/logos-12-12.png" alt="FreshBytes Logo">
            <span class="brand-name">FreshBytes</span>
        </a>

        <ul class="nav-links">
            <li><a href="#">Home</a></li>
            <li><a href="#">Shop</a></li>
            <li><a href="#">Pages</a></li>
            <li><a href="#">Coupons</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Contact</a></li>
        </ul>

        <form class="search-shell" action="#" method="get">
            <div class="search-icon">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.6-5.15a6.75 6.75 0 11-13.5 0 6.75 6.75 0 0113.5 0z" />
                </svg>
            </div>
            <input type="text" placeholder="Search for products keywords ..." aria-label="Search products">
            <button type="submit">Search</button>
        </form>

        <div class="nav-icons">
            @guest
                <a href="{{ route('auth.signup') }}" class="user-pill" aria-label="Register">
                    <span class="icon-bubble">
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19a6 6 0 10-12 0m12 0h3m-3 0a3 3 0 003 3m-9-10a4 4 0 110-8 4 4 0 010 8z" />
                        </svg>
                    </span>
                    <span>Hello<br><strong>Register</strong></span>
                </a>
            @endguest

            @auth
                <form action="{{ route('auth.logout') }}" method="post" class="user-pill">
                    @csrf
                    <button type="submit" class="menu-square" aria-label="Logout" style="width: auto; height: 34px; padding: 0 12px; border-radius: 999px;">
                        Logout
                    </button>
                </form>
            @endauth

            <a href="{{ route('cart.index') }}" class="icon-badge" aria-label="Wishlist">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21s-7-4.35-7-10a4 4 0 017-2.65A4 4 0 0119 11c0 5.65-7 10-7 10z" />
                </svg>
                <span>0</span>
            </a>

            <a href="{{ route('cart.index') }}" class="icon-badge" aria-label="Cart">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.2 6m1.2-6l1.8 6m9-6l-1.8 6M9 19a1 1 0 102 0 1 1 0 00-2 0zm7 0a1 1 0 102 0 1 1 0 00-2 0z" />
                </svg>
                <span>{{ session('cart') ? count(session('cart')) : 0 }}</span>
            </a>
        </div>
    </div>
</nav>