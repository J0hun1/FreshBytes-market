<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_name',
        'product_brief_description',
        'product_detailed_description',
        'product_price',
        'product_discountedPrice',
        'product_sku',
        'product_unit',
        'product_status',
        'product_location',
        'user_id',
        'category_id',
        'quantity',
        'post_date',
        'harvest_date',
        'is_active',
        'seller_id',
        'discounted_amount',
        'is_discounted',
        'is_sale',
        'is_srp',
        'is_deleted',
        'brand',
        'top_rated',
        'sell_count',
        'offer_start_date',
        'offer_end_date',
        'promo_price',
        'image'
    ];

    protected $casts = [
        'product_price' => 'decimal:2',
        'product_discountedPrice' => 'decimal:2',
        'discounted_amount' => 'decimal:2',
        'promo_price' => 'decimal:2',
        'post_date' => 'date',
        'harvest_date' => 'date',
        'offer_start_date' => 'date',
        'offer_end_date' => 'date',
    ];

    public function getImageUrlAttribute()
    {
        $catalogProducts = config('market_catalog.products', []);
        $normalizedName = strtolower(trim((string) $this->product_name));
        $catalogImage = null;

        if (isset($catalogProducts[$normalizedName]['image'])) {
            $catalogImage = $catalogProducts[$normalizedName]['image'];
        } else {
            foreach ($catalogProducts as $name => $profile) {
                if ((str_contains($normalizedName, $name) || str_contains($name, $normalizedName)) && isset($profile['image'])) {
                    $catalogImage = $profile['image'];
                    break;
                }
            }
        }

        $fallback = config('market_catalog.fallback.image', 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=600&q=80');

        if (!$this->image) {
            return $catalogImage ?? $fallback;
        }

        // Allow absolute URLs for legacy or externally hosted records.
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        return Storage::disk('public')->exists('images/products/' . $this->image)
            ? asset('storage/images/products/' . $this->image)
            : ($catalogImage ?? $fallback);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }
}
