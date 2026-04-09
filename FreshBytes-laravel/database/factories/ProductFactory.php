<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $price = fake()->randomFloat(2, 10, 500);
        $discount = fake()->boolean(50) ? fake()->randomFloat(2, 0, $price * 0.5) : 0;
        
        return [
            'product_name' => fake()->words(3, true),
            'product_brief_description' => fake()->sentence(),
            'product_detailed_description' => fake()->paragraph(),
            'product_price' => $price,
            'product_discountedPrice' => $price - $discount,
            'product_sku' => fake()->unique()->bothify('FBP-######'),
            'product_unit' => fake()->randomElement(['kg', 'piece', 'box', 'liter']),
            'product_status' => 'fresh',
            'product_location' => fake()->city(),
            'user_id' => null,
            'category_id' => null,
            'quantity' => fake()->numberBetween(1, 1000),
            'post_date' => now(),
            'harvest_date' => now()->subDays(fake()->numberBetween(1, 30)),
            'is_active' => true,
            'seller_id' => null,
            'discounted_amount' => $discount,
            'is_discounted' => $discount > 0,
            'is_sale' => fake()->boolean(20),
            'is_srp' => fake()->boolean(10),
            'is_deleted' => false,
            'brand' => fake()->company(),
            'top_rated' => false,
            'sell_count' => fake()->numberBetween(0, 100),
            'offer_start_date' => null,
            'offer_end_date' => null,
            'promo_price' => null,
        ];
    }
}
