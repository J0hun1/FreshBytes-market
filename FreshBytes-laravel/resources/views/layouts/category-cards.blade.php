<section class="category-wrap">
    <div class="content-shell">
        <p class="section-overline">Shop by Category</p>
        <h2 class="section-title">Popular on FreshBytes</h2>

        @php
            $cardBackgrounds = ['#d5dfd1', '#ead7de', '#e7e3e3', '#d6e0cf', '#e9dccc'];
            $categoryImages = [
                'Leafy Greens' => 'https://images.unsplash.com/photo-1522184216316-3c25379f9760?auto=format&fit=crop&w=500&q=80',
                'Berries' => 'https://images.unsplash.com/photo-1464965911861-746a04b4bca6?auto=format&fit=crop&w=500&q=80',
                'Legumes' => 'https://images.unsplash.com/photo-1592921870789-04563d55041c?auto=format&fit=crop&w=500&q=80',
                'Root Vegetables' => 'https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?auto=format&fit=crop&w=500&q=80',
                'Tropical Fruits' => 'https://images.unsplash.com/photo-1619566636858-adf3ef46400b?auto=format&fit=crop&w=500&q=80',
                'Herbs' => 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=500&q=80',
                'Fresh Fruits' => 'https://images.unsplash.com/photo-1610832958506-aa56368176cf?auto=format&fit=crop&w=500&q=80',
                'Cruciferous' => 'https://images.unsplash.com/photo-1587049352851-8d4e89133924?auto=format&fit=crop&w=500&q=80',
                'Mushrooms' => 'https://images.unsplash.com/photo-1504545102780-26774c1bb073?auto=format&fit=crop&w=500&q=80',
                'Citrus Fruits' => 'https://images.unsplash.com/photo-1611080626919-7cf5a9dbab5b?auto=format&fit=crop&w=500&q=80',
                'Alliums' => 'https://images.unsplash.com/photo-1518977676601-b53f82aba655?auto=format&fit=crop&w=500&q=80',
                'Organic' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=500&q=80'
            ];
        @endphp

        <div class="category-grid">
            @foreach($categories->take(5) as $index => $category)
                <article class="category-card" style="background-color: {{ $cardBackgrounds[$index % count($cardBackgrounds)] }};">
                    <h3>{{ $category->category_name }}</h3>
                    <p>{{ $products->where('category_id', $category->category_id)->count() }} Items</p>
                    <img src="{{ $categoryImages[$category->category_name] ?? 'https://images.unsplash.com/photo-1557844352-761f2565b576?auto=format&fit=crop&w=500&q=80' }}" alt="{{ $category->category_name }}">
                </article>
            @endforeach
        </div>
    </div>
</section>