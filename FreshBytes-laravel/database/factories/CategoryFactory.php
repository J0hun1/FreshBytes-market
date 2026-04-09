<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_name' => fake()->word(),
            'category_description' => fake()->sentence(),
            'category_isActive' => true,
            'parent_category_id' => null, // or Category::factory() for children
            'category_image' => fake()->imageUrl(),
        ];
    }
}
