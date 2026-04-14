<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FreshBytes | {{ $recipe['title'] }}</title>
    <link rel="icon" type="image/png" href="/images/logos-12-12.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Freeman&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="market-page-body market-subpage-body">
    <div class="market-page-wrap">
        @include('layouts.market-navbar')

        <main class="market-main market-subpage-main">
            <section class="market-subpage-shell market-list-shell market-recipe-shell">
                <div class="market-page-head-row">
                    <h1 class="market-subpage-title">{{ $recipe['title'] }}</h1>
                    <a href="{{ route('market.home') }}#nutritional-products" class="market-back-link">Back to Nutritional</a>
                </div>

                <p class="market-page-summary">{{ $recipe['intro'] }}</p>

                <img src="{{ $recipe['image'] }}" alt="{{ $recipe['title'] }}" class="market-recipe-image" onerror="this.onerror=null;this.src='/images/nutritional_1.png';">

                <div class="market-recipe-grid">
                    <article class="market-recipe-content">
                        <h2>Ingredients</h2>
                        <ul class="market-recipe-list">
                            @foreach(($recipe['ingredients'] ?? []) as $ingredient)
                                <li>{{ $ingredient }}</li>
                            @endforeach
                        </ul>
                    </article>

                    <article class="market-recipe-content">
                        <h2>Procedure</h2>
                        <ol class="market-recipe-list market-recipe-steps">
                            @foreach(($recipe['procedure'] ?? []) as $step)
                                <li>{{ $step }}</li>
                            @endforeach
                        </ol>
                    </article>
                </div>

                <article class="market-recipe-content">
                    <div class="market-page-head-row">
                        <h2>FreshBytes Shopping List</h2>
                        <form action="{{ route('cart.recipe.add', $recipe['slug']) }}" method="post">
                            @csrf
                            <button type="submit" class="market-cart-btn market-recipe-action-btn">Add recipe products to cart</button>
                        </form>
                    </div>

                    @if(($shoppingItems ?? collect())->isNotEmpty())
                        <div class="market-recipe-products">
                            @foreach($shoppingItems as $item)
                                <article class="market-recipe-product-card">
                                    <div>
                                        <h3>{{ $item['name'] }}</h3>
                                        <p>{{ $item['quantity'] }} {{ $item['unit'] }}</p>
                                        <p>{{ $item['stock_label'] }}</p>
                                        @if($item['note'])
                                            <p>{{ $item['note'] }}</p>
                                        @endif
                                    </div>

                                    @if($item['product'])
                                        <div class="market-recipe-product-meta">
                                            <img src="{{ $item['product']->image_url }}" alt="{{ $item['product']->product_name }}">
                                            <p>{{ $item['product']->product_name }}</p>
                                            <form action="{{ route('cart.add', $item['product']->product_id) }}" method="post">
                                                @csrf
                                                <button type="submit" class="market-cart-btn market-recipe-item-btn">Add item</button>
                                            </form>
                                        </div>
                                    @else
                                        <p class="market-detail-text">No stocks available in FreshBytes yet.</p>
                                    @endif
                                </article>
                            @endforeach
                        </div>
                    @else
                        <p class="market-detail-text">No shopping items have been configured for this recipe yet.</p>
                    @endif
                </article>
            </section>
        </main>

        <div class="market-shared-footer" id="market-footer">
            @include('layouts.footer')
        </div>
    </div>
</body>

</html>
