<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
final class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'internal_code' => fake()->bothify('PRD-####'),
            'name' => fake()->unique()->words(3, true),
            'unit' => fake()->randomElement(['m2', 'un', 'kg', 'm', 'litro']),
            'price' => fake()->randomFloat(2, 1, 9999),
            'category' => fake()->optional()->randomElement(['madeira', 'cimento', 'acabamento']),
            'notes' => fake()->optional()->sentence(),
            'is_active' => true,
            'product_category_id' => null,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (): array => [
            'is_active' => false,
        ]);
    }

    public function withCategory(): static
    {
        $categoryName = fake()->randomElement(['Madeira', 'Cimento', 'Acabamento']);

        return $this
            ->for(
                ProductCategory::factory()->state([
                    'name' => $categoryName,
                    'slug' => Str::slug($categoryName).'-'.fake()->unique()->numberBetween(1, 9999),
                ]),
                'productCategory',
            )
            ->state([
                'category' => $categoryName,
            ]);
    }
}
