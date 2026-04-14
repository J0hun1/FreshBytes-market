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

        <div class="featured-grid">
            @foreach($products as $product)
                <article class="featured-card">
                    <a href="{{ route('product.show', $product->product_id) }}" class="featured-image-wrap">
                        <img src="{{ $product->image_url ?? 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $product->product_name }}">
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
