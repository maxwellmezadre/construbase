<?php

declare(strict_types=1);

use App\Models\Product;
use App\Models\ProductCategory;

it('creates a valid product via factory', function (): void {
    $product = Product::factory()->withCategory()->create();

    expect($product->internal_code)->not->toBeNull()
        ->and($product->name)->not->toBeEmpty()
        ->and($product->unit)->not->toBeEmpty()
        ->and($product->price)->toBeString()
        ->and($product->productCategory)->toBeInstanceOf(ProductCategory::class)
        ->and($product->is_active)->toBeTrue();
});

it('resolves the product category relationship', function (): void {
    $category = ProductCategory::factory()->create();
    $product = Product::factory()->for($category, 'productCategory')->create();

    expect($product->productCategory)->not->toBeNull()
        ->and($product->productCategory->is($category))->toBeTrue();
});

it('casts price as decimal string', function (): void {
    $product = Product::factory()->create([
        'price' => 12.5,
    ]);

    expect($product->price)->toBe('12.50');
});
