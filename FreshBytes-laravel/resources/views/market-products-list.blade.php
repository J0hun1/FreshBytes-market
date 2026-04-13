<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} | FreshBytes</title>
    <link rel="icon" type="image/png" href="/images/logos-12-12.png">
    @vite(['resources/css/app.css'])
</head>
<body class="market-page-body" style="font-family:'Outfit',sans-serif;">
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
    @endphp
    @include('layouts.market-navbar')

    <main class="market-main" style="max-width:1300px;margin:18px auto 36px;padding:24px;">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;">
            <h1 style="margin:0;color:#fff;font-size:52px;">{{ $title }}</h1>
            <a href="{{ route('market.home') }}" style="text-decoration:none;background:#9ee19e;color:#043522;border-radius:10px;padding:10px 16px;font-weight:700;">Back to Market</a>
        </div>

        <section style="margin-top:18px;" class="market-product-grid">
            @foreach($products as $product)
                @php
                    $img = $productImages[$product->product_name] ?? 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=640&q=80';
                @endphp
                <article class="market-product-card">
                    <a href="{{ route('product.show', $product->product_id) }}" class="market-product-thumb">
                        <img src="{{ $img }}" alt="{{ $product->product_name }}">
                    </a>
                    <div class="market-product-details">
                        <p class="market-product-title">{{ $product->product_name }}</p>
                        <p class="market-product-price">₱{{ number_format($product->product_price, 2) }} / {{ $product->product_unit ?? 'kg' }}</p>
                        <p class="market-product-meta">{{ $product->sell_count ?? 0 }} sold</p>
                        <p class="market-product-loc"><span>{{ $product->product_location }}</span></p>
                        <form action="{{ route('cart.add', $product->product_id) }}" method="post" class="market-cart-form">
                            @csrf
                            <input type="hidden" name="return_anchor" value="fresh-near-you">
                            <button type="submit" class="market-cart-btn">Add to cart</button>
                        </form>
                    </div>
                </article>
            @endforeach
        </section>
    </main>

    @include('layouts.footer')
</body>
</html>
