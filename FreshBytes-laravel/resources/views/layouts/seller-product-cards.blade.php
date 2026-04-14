<section class="market-product-grid">
    @forelse($products as $product)
        <article class="market-product-card group relative overflow-hidden transform hover:-translate-y-1 hover:shadow-2xl transition-all duration-300">
            <!-- Product Image -->
            <div class="market-product-thumb">
                <img src="{{ $product->image ? asset('storage/images/products/' . $product->image) : 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=600&q=80' }}" 
                     alt="{{ $product->product_name }}" class="w-full h-full object-cover">
                <!-- Quick Actions Overlay -->
                <div class="absolute top-2 right-2 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10">
                    <a href="{{ route('product.show', $product->product_id) }}" class="w-9 h-9 bg-white/90 backdrop-blur-sm rounded-lg flex items-center justify-center text-green-900 font-bold hover:bg-green-400/90 hover:scale-105 transition-all duration-200 text-sm" title="View">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </a>
                    <a href="{{ route('seller.product.edit', $product->product_id) }}" class="w-9 h-9 bg-white/90 backdrop-blur-sm rounded-lg flex items-center justify-center text-blue-600 font-bold hover:bg-blue-400/90 hover:scale-105 transition-all duration-200 text-sm" title="Edit">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                    </a>
                    <form method="POST" action="{{ route('seller.product.destroy', $product->product_id) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this product?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-9 h-9 bg-white/90 backdrop-blur-sm rounded-lg flex items-center justify-center text-red-600 font-bold hover:bg-red-400/90 hover:scale-105 transition-all duration-200 text-sm border-0 bg-transparent cursor-pointer p-0 m-0" title="Delete">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Product Details -->
            <div class="market-product-details">
                <h3 class="market-product-title line-clamp-2">{{ substr($product->product_name, 0, 40) . (strlen($product->product_name) > 40 ? '...' : '') }}</h3>
                
                <!-- Status Badge -->
                <span class="absolute top-2 left-2 px-2 py-1 rounded-full text-xs font-bold @if($product->product_status === 'fresh') bg-green-400/80 text-green-900 @else bg-yellow-400/80 text-gray-900 @endif">
                    {{ ucfirst($product->product_status ?? 'Unknown') }}
                </span>
                
                <!-- Price & Stats -->
                <p class="market-product-price">₱{{ number_format($product->product_price, 2) }}</p>
                <div class="market-product-meta">
                    {{ $product->quantity }} {{ $product->product_unit }} 
                    • {{ $product->sell_count }} sold
                </div>
                <p class="market-product-copy line-clamp-2">{{ substr($product->product_brief_description ?? '', 0, 80) . (strlen($product->product_brief_description ?? '') > 80 ? '...' : '') }}</p>
                
                <!-- Posted Time -->
                <p class="market-product-time">{{ $product->post_date->diffForHumans() }}</p>
            </div>
        </article>
    @empty
        <div class="col-span-full text-center py-16">
            <p class="text-white/70 text-lg">No products yet. Add your first product!</p>
        </div>
    @endforelse
</section>


