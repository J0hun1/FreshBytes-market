<section class="products-wrap">
    <div class="content-shell">
        <p class="section-overline left">All Product Shop</p>
        <div class="featured-head">
            <h2 class="section-title left">Featured Products</h2>

            <ul class="product-tabs">
                <li><a href="#" class="active">All Product</a></li>
                <li><a href="#">Frozen Foods</a></li>
                <li><a href="#">Meat and Fish</a></li>
                <li><a href="#">Milk &amp; Dairy</a></li>
            </ul>
        </div>

        @php
            $productImages = [
                'Fresh Spinach' => 'https://images.unsplash.com/photo-1574316071802-0d684efa7bf5?auto=format&fit=crop&w=600&q=80',
                'Strawberries' => 'https://images.unsplash.com/photo-1587393855524-087f83d95ac3?auto=format&fit=crop&w=600&q=80',
                'Carrots' => 'https://images.unsplash.com/photo-1447175008436-054170c2e979?auto=format&fit=crop&w=600&q=80',
                'Mangoes' => 'https://images.unsplash.com/photo-1553279768-865429fa0078?auto=format&fit=crop&w=600&q=80',
                'Basil Leaves' => 'https://images.unsplash.com/photo-1618375569909-3c8616cf7733?auto=format&fit=crop&w=600&q=80'
            ];
        @endphp

        <div class="featured-grid">
            @foreach($products as $product)
                <article class="featured-card">
                    <a href="{{ route('product.show', $product->product_id) }}" class="featured-image-wrap">
                        <img src="{{ $productImages[$product->product_name] ?? 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $product->product_name }}">
                    </a>

                    <div class="featured-body">
                        <h3>{{ $product->product_name }}</h3>
                        <p>{{ $product->product_brief_description }}</p>

                        <div class="featured-meta">
                            <strong>₱{{ number_format($product->product_price, 2) }}</strong>
                            <span>{{ $product->sell_count }} sold</span>
                        </div>

                        <form action="{{ route('cart.add', $product->product_id) }}" method="POST">
                            @csrf
                            <button type="submit">Add to cart</button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
