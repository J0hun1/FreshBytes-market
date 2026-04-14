<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Seller Dashboard | FreshBytes</title>
    <link rel="icon" type="image/png" href="/images/logos-12-12.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="market-page-body font-outfit">
    @include('layouts.market-navbar')

    <main class="max-w-7xl mx-auto p-6 lg:p-12">
        @if (session('info'))
            <div class="bg-blue-500/20 border border-blue-500/50 text-blue-100 p-6 rounded-2xl mb-8 text-center">
                {{ session('info') }}
            </div>
        @endif

        <!-- Header -->
        <div class="text-center lg:text-left mb-12">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 leading-tight">
                Your Seller Dashboard
            </h1>
            <p class="text-xl md:text-2xl text-white/80 font-medium">
                Manage your products, {{ $seller->business_name }}
            </p>
        </div>

        <div class="grid lg:grid-cols-4 gap-8">
            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Add Product Button -->
                <div class="">
                    <a href="{{ route('seller.product.create') }}" class="block w-full bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold text-xl py-6 px-8 rounded-2xl shadow-2xl hover:shadow-green-500/50 transform hover:-translate-y-1 transition-all duration-300">
                        + Add New Product
                    </a>
                </div>

                <!-- Stats -->
                <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl p-6 space-y-4 shadow-2xl">
                    <h3 class="text-white font-bold text-lg">Your Stats</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between text-white/90">
                            <span>Total Products</span>
                            <span class="font-bold text-xl">{{ $products->count() }}</span>
                        </div>
                        <div class="flex justify-between text-white/90">
                            <span>Total Sales</span>
                            <span class="font-bold text-xl">₱{{ number_format($seller->total_sales, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-white/90">
                            <span>Rating</span>
                            <span class="font-bold text-xl">{{ number_format($seller->rating, 1) }}/5</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products -->
            <div class="lg:col-span-3">
                @if($products->count() > 0)
@include('layouts.seller-product-cards', ['products' => $products])
                @else
                    <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl p-16 text-center shadow-2xl">
                        <div class="w-24 h-24 bg-green-500/20 rounded-full mx-auto mb-6 flex items-center justify-center">
                            <svg class="w-12 h-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4l-8-4M4 7l8 4m0 0l8 4m-8-4v12m0 0L4 21l8-4m0 4L20 21" />
                            </svg>
                        </div>
                        <h3 class="text-2xl md:text-3xl font-bold text-white mb-4">No products yet</h3>
                        <p class="text-xl text-white/80 mb-8">Get started by adding your first product to reach thousands of customers!</p>
                        <a href="{{ route('seller.product.create') }}" class="inline-flex items-center gap-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold px-8 py-4 rounded-2xl shadow-2xl hover:shadow-green-500/50 transform hover:-translate-y-1 transition-all duration-300">
                            Add Your First Product
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </main>
</body>
</html>
