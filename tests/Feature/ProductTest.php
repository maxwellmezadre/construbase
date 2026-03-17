<?php

declare(strict_types=1);

use App\Models\Product;
use App\Models\ProductCategory;

it('creates a product with the minimum required fields', function (): void {
    $product = Product::query()->create([
        'name' => 'Cimento CP II',
        'unit' => 'un',
        'price' => 39.9,
    ]);

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'name' => 'Cimento CP II',
        'unit' => 'un',
        'price' => '39.90',
        'is_active' => true,
    ]);
});

it('creates a product with an associated category', function (): void {
    $category = ProductCategory::factory()->create([
        'name' => 'Madeira',
        'slug' => 'madeira',
    ]);

    $product = Product::query()->create([
        'name' => 'Viga de pinus',
        'unit' => 'm',
        'price' => 59.9,
        'product_category_id' => $category->id,
        'category' => $category->name,
    ]);

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'product_category_id' => $category->id,
        'category' => 'Madeira',
    ]);

    expect($product->fresh()->productCategory?->is($category))->toBeTrue();
});
