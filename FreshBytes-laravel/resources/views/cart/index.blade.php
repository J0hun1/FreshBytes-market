<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cart - {{ config('app.name', 'FreshBytes Market') }}</title>
    <link rel="icon" type="image/png" href="/images/logos-12-12.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="market-page-body" style="font-family:'Outfit',sans-serif;">
    @include('layouts.market-navbar')

    <main class="market-main" style="max-width:1200px;margin:18px auto 40px;padding:30px;">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:16px;flex-wrap:wrap;">
            <h1 style="margin:0;font-family:'Outfit',sans-serif;font-size:52px;line-height:1;color:#fff;">Shopping Cart</h1>
            <a href="{{ route('market.home') }}" style="text-decoration:none;background:#9ee19e;color:#043522;padding:10px 18px;border-radius:10px;font-weight:700;">Continue Shopping</a>
        </div>

        @if(session('success'))
            <div style="margin-top:16px;background:rgba(158,225,158,0.18);border:1px solid rgba(158,225,158,0.45);color:#ecfff2;padding:12px 14px;border-radius:10px;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="margin-top:16px;background:rgba(242,168,168,0.2);border:1px solid rgba(242,168,168,0.45);color:#fff;padding:12px 14px;border-radius:10px;">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div style="margin-top:16px;background:rgba(242,168,168,0.2);border:1px solid rgba(242,168,168,0.45);color:#fff;padding:12px 14px;border-radius:10px;">
                <ul style="margin:0;padding-left:16px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(empty($cart))
            <section style="margin-top:22px;background:rgba(217,217,217,0.1);border-radius:14px;padding:30px;text-align:center;">
                <h2 style="margin:0 0 8px;font-family:'Outfit',sans-serif;color:#fff;">Your cart is empty</h2>
                <p style="margin:0;color:rgba(255,255,255,0.82);">Add products from market home to continue checkout.</p>
            </section>
        @else
            @php
                $total = 0;
                foreach ($cart as $item) {
                    $total += $item['price'] * $item['quantity'];
                }
            @endphp

            <section style="margin-top:22px;display:grid;grid-template-columns:2fr 1fr;gap:20px;align-items:start;">
                <div style="display:grid;gap:14px;">
                    @foreach($cart as $id => $item)
                        @php $subtotal = $item['price'] * $item['quantity']; @endphp
                        <article style="display:flex;gap:14px;background:rgba(217,217,217,0.1);border-radius:14px;padding:12px;">
                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" style="width:110px;height:110px;border-radius:10px;object-fit:cover;">
                            <div style="flex:1;">
                                <h3 style="margin:0 0 6px;color:#fff;font-size:22px;">{{ $item['name'] }}</h3>
                                <p style="margin:0;color:#9ee19e;font-weight:700;">₱{{ number_format($item['price'], 2) }}</p>
                                <p style="margin:4px 0 10px;color:rgba(255,255,255,0.8);">Subtotal: ₱{{ number_format($subtotal, 2) }}</p>

                                <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
                                    <form method="post" action="{{ route('cart.update', $id) }}" style="display:flex;gap:6px;align-items:center;">
                                        @csrf
                                        <label for="qty-{{ $id }}" style="font-size:12px;color:rgba(255,255,255,0.82);">Qty</label>
                                        <input id="qty-{{ $id }}" type="number" name="quantity" min="1" max="99" value="{{ $item['quantity'] }}" style="width:72px;height:34px;border-radius:8px;border:1px solid rgba(255,255,255,0.25);background:rgba(0,0,0,0.2);color:#fff;padding:0 8px;">
                                        <button type="submit" style="height:34px;border:0;border-radius:8px;padding:0 12px;background:#9ee19e;color:#043522;font-weight:700;cursor:pointer;">Update</button>
                                    </form>

                                    <form method="post" action="{{ route('cart.remove', $id) }}">
                                        @csrf
                                        <button type="submit" style="height:34px;border:0;border-radius:8px;padding:0 12px;background:rgba(242,168,168,0.85);color:#2a1010;font-weight:700;cursor:pointer;">Remove</button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <aside style="background:rgba(217,217,217,0.1);border-radius:14px;padding:16px;">
                    <h2 style="margin:0 0 12px;color:#fff;font-size:24px;">Checkout</h2>
                    <p style="margin:0 0 14px;color:rgba(255,255,255,0.85);">Total: <strong style="color:#9ee19e;">₱{{ number_format($total, 2) }}</strong></p>

                    <form method="post" action="{{ route('cart.checkout') }}" style="display:grid;gap:10px;" onsubmit="return confirm('Proceed with checkout and place this order?');">
                        @csrf
                        <input type="text" name="full_name" placeholder="Full name" required style="height:40px;border-radius:8px;border:1px solid rgba(255,255,255,0.25);background:rgba(0,0,0,0.2);color:#fff;padding:0 10px;">
                        <input type="text" name="address" placeholder="Delivery address" required style="height:40px;border-radius:8px;border:1px solid rgba(255,255,255,0.25);background:rgba(0,0,0,0.2);color:#fff;padding:0 10px;">
                        <select name="payment_method" required style="height:40px;border-radius:8px;border:1px solid rgba(255,255,255,0.25);background:rgba(9,50,22,0.72);color:#fff;padding:0 10px;">
                            <option value="">Select payment method</option>
                            <option value="cod" style="color:#0b1a2f;">Cash on Delivery</option>
                            <option value="gcash" style="color:#0b1a2f;">GCash</option>
                            <option value="card" style="color:#0b1a2f;">Card</option>
                        </select>
                        <button type="submit" style="height:42px;border:0;border-radius:10px;background:#9ee19e;color:#043522;font-weight:700;font-size:16px;cursor:pointer;">Proceed to Checkout</button>
                    </form>
                </aside>
            </section>
        @endif
    </main>

    @include('layouts.footer')
</body>
</html>
