<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Account | FreshBytes</title>
    <link rel="icon" type="image/png" href="/images/logos-12-12.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="market-page-body" style="font-family:'Outfit',sans-serif;">
    @include('layouts.market-navbar')

    <main class="market-main" style="max-width:1200px;margin:18px auto 36px;padding:24px;">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;">
            <h1 style="margin:0;color:#fff;font-size:52px;font-family:'Outfit',sans-serif;">My Account</h1>
            <a href="{{ route('market.home') }}" style="text-decoration:none;background:#9ee19e;color:#043522;border-radius:10px;padding:10px 16px;font-weight:700;">Back to Market</a>
        </div>

        @if(session('success'))
            <div style="margin-top:14px;background:rgba(158,225,158,0.2);border:1px solid rgba(158,225,158,0.5);padding:10px 12px;border-radius:10px;color:#ecfff2;">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div style="margin-top:14px;background:rgba(242,168,168,0.2);border:1px solid rgba(242,168,168,0.5);padding:10px 12px;border-radius:10px;color:#fff;">
                <ul style="margin:0;padding-left:16px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section style="margin-top:18px;display:grid;grid-template-columns:1fr 1fr;gap:20px;">
            <article style="background:rgba(217,217,217,0.1);border-radius:14px;padding:16px;">
                <h2 style="margin:0 0 12px;color:#fff;">Account Settings</h2>
                <form method="post" action="{{ route('account.settings.update') }}" style="display:grid;gap:10px;">
                    @csrf
                    <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" placeholder="First name" required style="height:40px;border-radius:8px;border:1px solid rgba(255,255,255,0.25);background:rgba(0,0,0,0.2);color:#fff;padding:0 10px;">
                    <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" placeholder="Last name" required style="height:40px;border-radius:8px;border:1px solid rgba(255,255,255,0.25);background:rgba(0,0,0,0.2);color:#fff;padding:0 10px;">
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Phone" style="height:40px;border-radius:8px;border:1px solid rgba(255,255,255,0.25);background:rgba(0,0,0,0.2);color:#fff;padding:0 10px;">
                    <textarea name="address" placeholder="Address" style="min-height:86px;border-radius:8px;border:1px solid rgba(255,255,255,0.25);background:rgba(0,0,0,0.2);color:#fff;padding:10px;">{{ old('address', $user->address) }}</textarea>
                    <button type="submit" style="height:42px;border:0;border-radius:10px;background:#9ee19e;color:#043522;font-weight:700;cursor:pointer;">Save Settings</button>
                </form>
            </article>

            <article style="background:rgba(217,217,217,0.1);border-radius:14px;padding:16px;">
                <h2 style="margin:0 0 12px;color:#fff;">Your Orders</h2>
                @if($orders->isEmpty())
                    <p style="margin:0;color:rgba(255,255,255,0.84);">No orders yet. Place your first order from market home.</p>
                @else
                    <div style="display:grid;gap:10px;max-height:460px;overflow:auto;padding-right:4px;">
                        @foreach($orders as $order)
                            @php
                                $orderId = is_array($order) ? ($order['order_id'] ?? '-') : $order->order_id;
                                $orderTotal = is_array($order) ? (float) ($order['total_amount'] ?? 0) : (float) $order->total_amount;
                                $orderStatus = is_array($order) ? ($order['status'] ?? 'placed') : $order->status;
                                $orderDate = is_array($order)
                                    ? \Carbon\Carbon::parse($order['created_at'] ?? now())->format('M d, Y h:i A')
                                    : ($order->created_at?->format('M d, Y h:i A') ?? now()->format('M d, Y h:i A'));
                                $orderItems = is_array($order) ? collect($order['items'] ?? []) : $order->items;
                            @endphp
                            <div style="background:rgba(0,0,0,0.2);border-radius:10px;padding:10px;">
                                <p style="margin:0;color:#9ee19e;font-weight:700;">Order #{{ $orderId }} - ₱{{ number_format($orderTotal, 2) }}</p>
                                <p style="margin:3px 0;color:rgba(255,255,255,0.82);font-size:13px;">{{ ucfirst($orderStatus) }} • {{ $orderDate }}</p>
                                <ul style="margin:6px 0 0;padding-left:16px;color:#fff;">
                                    @foreach($orderItems as $item)
                                        @php
                                            $itemName = is_array($item) ? ($item['product_name'] ?? 'Item') : $item->product_name;
                                            $itemQty = is_array($item) ? ((int) ($item['quantity'] ?? 1)) : $item->quantity;
                                            $itemSubtotal = is_array($item) ? ((float) ($item['subtotal'] ?? 0)) : ((float) $item->subtotal);
                                        @endphp
                                        <li>{{ $itemName }} x{{ $itemQty }} (₱{{ number_format($itemSubtotal, 2) }})</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                @endif
            </article>
        </section>
    </main>

    @include('layouts.footer')
</body>
</html>
