<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>List Your Product - FreshBytes</title>
    <link rel="icon" type="image/png" href="/images/logos-12-12.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="market-page-body font-outfit">
    @include('layouts.market-navbar')

    <main class="market-main max-w-4xl mx-auto p-10 md:p-12 lg:p-16">
        <div class="text-center mb-12">
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-white mb-6 leading-tight">List Your Product</h1>
            <p class="text-xl md:text-2xl text-white/80 font-medium">Start selling fresh produce to thousands of customers</p>
        </div>

        @if (session('success'))
            <div class="bg-green-500/20 border border-green-500/50 text-green-100 p-6 rounded-2xl mb-8 animate-pulse">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-500/20 border border-red-500/50 text-white p-6 rounded-2xl mb-8">
                <ul class="list-disc pl-6 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('seller.product.store') }}" enctype="multipart/form-data" class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl p-10 md:p-12 lg:p-16 space-y-8">
            @csrf
            
            <!-- Product Image Upload -->
            <div class="grid gap-4">
                <label class="text-white font-semibold text-lg">Product Image *</label>
                    <div class="relative">
                    <input type="file" name="image" id="productImage" required class="w-full h-48 md:h-64 border-2 border-dashed border-white/30 rounded-2xl bg-white/5 hover:border-green-400/70 transition-all duration-300 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-green-500/90 file:text-white hover:file:bg-green-600 cursor-pointer text-white p-4 relative z-10">
                    <div id="imagePreview" class="absolute inset-0 w-full h-full bg-cover bg-center rounded-2xl opacity-0 transition-opacity duration-300 pointer-events-none z-0"></div>
                </div>
                <p class="text-white/70 text-sm">Upload JPEG, PNG, JPG (Max 5MB). High quality image recommended.</p>
                @error('image')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Product Name -->
            <div class="grid gap-3">
                <label class="text-white font-semibold text-lg">Product Name *</label>
                <input type="text" name="product_name" value="{{ old('product_name') }}" required class="h-14 rounded-2xl border border-white/30 bg-black/20 text-white placeholder-white/60 p-4 text-lg focus:border-green-400/70 focus:ring-2 focus:ring-green-400/30 focus:bg-white/10 transition-all duration-300">
            </div>

            <!-- Brief Description -->
            <div class="grid gap-3">
                <label class="text-white font-semibold text-lg">Brief Description *</label>
                <textarea name="product_brief_description" rows="3" required class="rounded-2xl border border-white/30 bg-black/20 text-white placeholder-white/60 p-6 text-lg resize-vertical focus:border-green-400/70 focus:ring-2 focus:ring-green-400/30 focus:bg-white/10 transition-all duration-300">{{ old('product_brief_description') }}</textarea>
            </div>

            <!-- Detailed Description -->
            <div class="grid gap-3">
                <label class="text-white font-semibold text-lg">Detailed Description</label>
                <textarea name="product_detailed_description" rows="4" class="rounded-2xl border border-white/30 bg-black/20 text-white placeholder-white/60 p-6 text-lg resize-vertical focus:border-green-400/70 focus:ring-2 focus:ring-green-400/30 focus:bg-white/10 transition-all duration-300">{{ old('product_detailed_description') }}</textarea>
            </div>

            <!-- Price & Category -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="grid gap-3">
                    <label class="text-white font-semibold text-lg">Price (₱) *</label>
                    <input type="number" name="product_price" step="0.01" min="0" value="{{ old('product_price') }}" required class="h-14 rounded-2xl border border-white/30 bg-black/20 text-white placeholder-white/60 p-4 text-lg focus:border-green-400/70 focus:ring-2 focus:ring-green-400/30 focus:bg-white/10 transition-all duration-300">
                </div>
                <div class="grid gap-3">
                    <label class="text-white font-semibold text-lg">Category *</label>
                    <select name="category_id" required class="h-14 rounded-2xl border border-white/30 bg-green-950/50 text-white placeholder-white/60 p-4 text-lg focus:border-green-400/70 focus:ring-2 focus:ring-green-400/30 focus:bg-green-900/70 transition-all duration-300">
                        <option value="">Select category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->category_id }}" {{ old('category_id') == $category->category_id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Location & Quantity -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="grid gap-3">
                    <label class="text-white font-semibold text-lg">Location *</label>
                    <input type="text" name="product_location" value="{{ old('product_location') }}" required class="h-14 rounded-2xl border border-white/30 bg-black/20 text-white placeholder-white/60 p-4 text-lg focus:border-green-400/70 focus:ring-2 focus:ring-green-400/30 focus:bg-white/10 transition-all duration-300">
                </div>
                <div class="grid gap-3">
                    <label class="text-white font-semibold text-lg">Quantity *</label>
                    <input type="number" name="quantity" min="1" value="{{ old('quantity', 1) }}" required class="h-14 rounded-2xl border border-white/30 bg-black/20 text-white placeholder-white/60 p-4 text-lg focus:border-green-400/70 focus:ring-2 focus:ring-green-400/30 focus:bg-white/10 transition-all duration-300">
                </div>
            </div>

            <!-- Unit & Harvest Date -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="grid gap-3">
                    <label class="text-white font-semibold text-lg">Unit *</label>
                    <input type="text" name="product_unit" value="{{ old('product_unit', 'kg') }}" required class="h-14 rounded-2xl border border-white/30 bg-black/20 text-white placeholder-white/60 p-4 text-lg focus:border-green-400/70 focus:ring-2 focus:ring-green-400/30 focus:bg-white/10 transition-all duration-300">
                </div>
                <div class="grid gap-3">
                    <label class="text-white font-semibold text-lg">Harvest Date *</label>
                    <input type="date" name="harvest_date" value="{{ old('harvest_date') }}" required class="h-14 rounded-2xl border border-white/30 bg-black/20 text-white placeholder-white/60 p-4 text-lg focus:border-green-400/70 focus:ring-2 focus:ring-green-400/30 focus:bg-white/10 transition-all duration-300">
                </div>
            </div>

            <!-- Brand -->
            <div class="grid gap-3">
                <label class="text-white font-semibold text-lg">Brand (Optional)</label>
                <input type="text" name="brand" value="{{ old('brand') }}" class="h-14 rounded-2xl border border-white/30 bg-black/20 text-white placeholder-white/60 p-4 text-lg focus:border-green-400/70 focus:ring-2 focus:ring-green-400/30 focus:bg-white/10 transition-all duration-300">
            </div>

            <button type="submit" class="h-16 w-full bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold text-xl rounded-2xl shadow-2xl hover:shadow-green-500/25 transform hover:-translate-y-1 transition-all duration-300">
                🚀 List Product Now
            </button>
        </form>

        <div class="text-center mt-12">
            <a href="{{ route('market.home') }}" class="inline-flex items-center gap-2 text-green-400 hover:text-green-300 font-semibold text-lg transition-colors duration-300">
                ← Back to Market
            </a>
        </div>
    </main>

    <script>
        document.getElementById('productImage').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('imagePreview');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.style.backgroundImage = `url(${e.target.result})`;
                    preview.style.opacity = '1';
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.backgroundImage = '';
                preview.style.opacity = '0';
            }
        });
    </script>

    <style>
        input[type="file"]::file-selector-button {
            margin-right: 1rem;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            border: 0;
            background: rgb(34 197 94 / 0.9);
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        input[type="file"]::file-selector-button:hover {
            background: rgb(22 163 74);
        }
    </style>
</body>
</html>
