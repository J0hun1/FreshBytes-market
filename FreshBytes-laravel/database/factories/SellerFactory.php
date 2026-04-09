<?php

namespace Database\Factories;

use App\Models\Seller;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Seller>
 */
class SellerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
'user_id' => \App\Models\User::factory(),
            'business_name' => fake()->company(),
            'business_address' => fake()->address(),
            'business_phone' => fake()->phoneNumber(),
            'business_email' => fake()->unique()->safeEmail(),
            'tax_id' => 'TAX' . fake()->unique()->numerify('###-###'),
            'bank_account_details' => json_encode(['account' => fake()->iban(), 'bank' => fake()->company()]),
            'commission_rate' => fake()->randomFloat(2, 0, 20),
            'is_verified' => fake()->boolean(30),
            'verification_documents' => json_encode([fake()->imageUrl(), fake()->imageUrl()]),
            'rating' => fake()->randomFloat(2, 0, 5),
            'total_sales' => fake()->numberBetween(0, 10000),
            'is_active' => true,
        ];
    }
}
