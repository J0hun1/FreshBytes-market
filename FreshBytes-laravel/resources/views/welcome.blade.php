<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'FreshBytes Market') }}</title>

    <link rel="icon" type="image/png" href="/images/FreshBytes_FinalNewLogoWhite.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="landing-page-body">
    <header class="landing-hero-wrap">
        <nav class="landing-topbar">
            <a href="{{ url('/') }}" class="landing-brand" aria-label="FreshBytes Home">
                <img src="/images/FreshBytes_FinalNewLogoWhite.png" alt="FreshBytes logo">
                <span>FreshBytes</span>
            </a>

            <ul class="landing-nav-links">
                <li><a href="#home">Home</a></li>
                <li><a href="#features">Features</a></li>
                <li><a href="#shop">Shop</a></li>
                <li><a href="#faqs">FAQs</a></li>
                <li><a href="#help">Help</a></li>
            </ul>

            <div class="landing-auth-links">
                <a href="{{ url('/login') }}">Log In</a>
                <a href="{{ url('/signup') }}">Sign Up</a>
            </div>
        </nav>

        <section class="landing-hero" id="home">
            <div class="landing-hero-copy">
                <h1>
                    <span class="landing-hero-line">Where <span class="landing-hero-accent-word">Freshness</span></span>
                    <span class="landing-hero-line">Is Guaranteed</span>
                </h1>
                <p>Bring fresh, local produce to your doorstep!</p>
                <a href="{{ route('auth.login') }}" class="landing-shop-btn">Shop Now</a>

                <div class="landing-app-download">
                    <p>App is coming soon! Stay tuned for updates.</p>
                    <div>
                        <img src="/images/home_gplay.png" alt="Download on Google Play">
                        <img src="/images/home_appstore.png" alt="Download on App Store">
                    </div>
                </div>
            </div>

            <div class="landing-hero-media">
                <img src="/images/FreshBytes_home.png" alt="FreshBytes produce showcase">
            </div>
        </section>
    </header>

    <main class="landing-main-content">
        <section class="landing-dyk-section" id="shop">
            <h2>Did You Know?</h2>
            <div class="landing-dyk-card">
                <img src="/images/home_DYKFINAL.png" alt="Did You Know panel">
            </div>
        </section>

        <section class="landing-about-section">
            <img src="/images/home_allAboutFB.png" alt="All About FreshBytes illustration">
            <article>
                <h3>All About FreshBytes</h3>
                <h4>A Web and Mobile Application</h4>
                <p>FreshBytes is a web and mobile-application exclusively for buying and selling fresh fruits and vegetables. Users can buy, sell, view, chat with sellers, and rate the listed products through the platform.</p>
            </article>
        </section>

        <section class="landing-features-section" id="features">
            <p class="landing-feature-label">Features</p>

            <div class="landing-feature-grid">
                <article class="landing-feature-text">
                    <h3>Discover, Choose, and Connect Effortlessly</h3>
                    <p>Discover trending items, view nutritional info, save favorites, chat with sellers, and manage orders. All with an easy switch between light and dark mode to suit your style.</p>
                </article>
                <img src="/images/home_feature1.png" alt="FreshBytes light and dark mode preview">
            </div>

            <div class="landing-feature-grid reverse">
                <img src="/images/home_feature2.png" alt="Explore products in detail preview">
                <article class="landing-feature-text">
                    <h3>Explore Products in Detail</h3>
                    <p>Check prices, seller ratings, and real-time availability, all verified with authenticity badges and save your favorites!</p>
                </article>
            </div>

            <div class="landing-feature-grid">
                <article class="landing-feature-text">
                    <h3>Your Personalized Profile</h3>
                    <p>Customize your shopping experience with a profile that grows with you. Track your orders, view past favorites, update preferences, and explore recommendations just for you.</p>
                </article>
                <img src="/images/home_feature3.png" alt="Personalized profile preview">
            </div>

            <div class="landing-feature-grid reverse">
                <img src="/images/home_feature4.png" alt="Navigational map preview">
                <article class="landing-feature-text">
                    <h3>Find Your Seller with Ease</h3>
                    <p>Use an interactive map to find sellers nearby, view pickup points, and navigate to locations for transactions!</p>
                </article>
            </div>
        </section>

        <section class="landing-faq-section" id="faqs">
            <h3>FAQs</h3>
            <div class="landing-faq-list">
                <details>
                    <summary>How can I be sure that the product is legit?</summary>
                    <p>Products are listed by verified sellers and include seller ratings and profile details so buyers can review credibility before purchase.</p>
                </details>
                <details>
                    <summary>How can the app detect the freshness of a product?</summary>
                    <p>We use computer vision to analyze photos of fruits and vegetables for signs of ripeness or spoilage. With TensorFlow, we filter images, detect edges, and identify objects to assess and categorize freshness.</p>
                </details>
            </div>
        </section>

        <section class="landing-help-section" id="help">
            <h3>Help</h3>
            <h4>Need Help?</h4>
            <p>Access support for account setup, ordering, app navigation, and troubleshooting common issues, or reach out to our support team for further assistance.</p>
        </section>
    </main>

    <footer class="landing-footer">
        <div class="landing-footer-brand">
            <div class="landing-footer-brand-head">
                <img src="/images/FreshBytes_FinalNewLogoWhite.png" alt="FreshBytes logo">
                <span>FreshBytes</span>
            </div>
            <p>Address:</p>
            <p>USM, Kabacan, North Cotabato</p>
        </div>

        <div>
            <h5>Links</h5>
            <a href="#home">Home</a>
            <a href="#shop">About</a>
            <a href="#features">Features</a>
            <a href="#faqs">FAQs</a>
            <a href="#help">Help</a>
        </div>

        <div>
            <h5>Contact Us</h5>
            <p>Email Us:</p>
            <a href="mailto:freshbytes@gmail.com">freshbytes2024@gmail.com</a>
        </div>

        <div>
            <h5>Follow Us</h5>
            <div class="landing-footer-socials">
                <a href="https://web.facebook.com/FreshBytes.UCC" target="_blank" rel="noopener noreferrer" aria-label="FreshBytes Facebook">
                    <img src="/images/home_iconfb.png" alt="Facebook">
                </a>
                <a href="https://www.instagram.com/_freshbytes" target="_blank" rel="noopener noreferrer" aria-label="FreshBytes Instagram">
                    <img src="/images/home_iconIG.png" alt="Instagram">
                </a>
            </div>
        </div>
    </footer>
</body>
</html>
