<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cart - {{ config('app.name', 'FreshBytes Market') }}</title>
    <link rel="icon" type="image/png" href="/images/logos-12-12.png">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] min-h-screen antialiased">
    @include('layouts.navbar')

    <main class="pt-20">
        <section class="py-8 bg-white dark:bg-gray-900">
            <div class="max-w-screen-xl px-4 mx-auto">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Shopping Cart</h1>
                
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if(empty($cart))
                    <div class="text-center py-12">
                        <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18l6 18h15l-6 21H6a2 2 0 0 1-2-2V3z"/>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Your cart is empty</h3>
                        <a href="/" class="bg-primary-700 text-white px-6 py-2 rounded-lg hover:bg-primary-800">Continue Shopping</a>
                    </div>
                @else
                    <div class="grid md:grid-cols-3 gap-8">
                        <!-- Cart Items -->
                        <div class="md:col-span-2 space-y-4">
                            @foreach($cart as $id => $item)
                            <div class="flex bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-20 h-20 object-cover rounded-lg mr-4">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ $item['name'] }}</h3>
                                    <p class="text-gray-500">${{ number_format($item['price'], 2) }}</p>
                                    <div class="flex items-center mt-2">
                                        <span class="mr-4">Qty: {{ $item['quantity'] }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <!-- Summary -->
                        <div class="bg-gray-50 dark:bg-gray-800 p-6 rounded-lg">
                            <h3 class="text-xl font-bold mb-4">Order Summary</h3>
                            <div class="space-y-2 mb-6">
                                @php $total = 0; @endphp
                                @foreach($cart as $item)
                                    @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                                    <div class="flex justify-between">
                                        <span>{{ $item['name'] }} ({{ $item['quantity'] }} x ${{ number_format($item['price'], 2) }})</span>
                                        <span>${{ number_format($subtotal, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <div class="border-t pt-4">
                                <div class="flex justify-between text-xl font-bold">
                                    <span>Total: ${{ number_format($total, 2) }}</span>
                                </div>
                            </div>
                            <a href="#" class="w-full block mt-6 bg-primary-700 text-white text-center py-3 rounded-lg hover:bg-primary-800 font-semibold">Proceed to Checkout</a>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </main>
</body>
</html>
