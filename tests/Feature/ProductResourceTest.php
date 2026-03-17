<?php

declare(strict_types=1);

use App\Filament\Admin\Resources\Products\Pages\CreateProduct;
use App\Filament\Admin\Resources\Products\Pages\EditProduct;
use App\Filament\Admin\Resources\Products\Pages\ListProducts;
use App\Models\Admin;
use App\Models\Product;
use App\Models\ProductCategory;
use Filament\Actions\DeleteAction;
use Filament\Facades\Filament;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

beforeEach(function (): void {
    Filament::setCurrentPanel('admin');

    $permissions = [
        'ViewAny:Product',
        'View:Product',
        'Create:Product',
        'Update:Product',
        'Delete:Product',
        'DeleteAny:Product',
    ];

    $role = Role::findOrCreate('super_admin', 'admin');

    foreach ($permissions as $permission) {
        $role->givePermissionTo(Permission::findOrCreate($permission, 'admin'));
    }

    $admin = Admin::factory()->create();
    $admin->assignRole($role);

    $this->actingAs($admin, 'admin');
});

it('allows an admin to list products', function (): void {
    $products = Product::factory()->count(3)->create();

    Livewire::test(ListProducts::class)
        ->assertCanSeeTableRecords($products);
});

it('allows an admin to create a product with valid data', function (): void {
    $category = ProductCategory::factory()->create([
        'name' => 'Madeira',
        'slug' => 'madeira',
    ]);

    Livewire::test(CreateProduct::class)
        ->fillForm([
            'internal_code' => 'PRD-1001',
            'name' => 'Tabua de pinus',
            'unit' => 'm',
            'price' => 49.9,
            'product_category_id' => $category->id,
            'category' => 'Madeira',
            'notes' => 'Estoque inicial',
            'is_active' => true,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas('products', [
        'internal_code' => 'PRD-1001',
        'name' => 'Tabua de pinus',
        'product_category_id' => $category->id,
    ]);
});

it('allows an admin to edit an existing product', function (): void {
    $product = Product::factory()->create([
        'name' => 'Produto antigo',
        'price' => 10,
    ]);

    Livewire::test(EditProduct::class, ['record' => $product->getRouteKey()])
        ->fillForm([
            'internal_code' => $product->internal_code,
            'name' => 'Produto atualizado',
            'unit' => 'kg',
            'price' => 79.9,
            'category' => $product->category,
            'is_active' => false,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'name' => 'Produto atualizado',
        'unit' => 'kg',
        'price' => '79.90',
        'is_active' => false,
    ]);
});

it('allows an admin to delete a product', function (): void {
    $product = Product::factory()->create();

    Livewire::test(EditProduct::class, ['record' => $product->getRouteKey()])
        ->callAction(DeleteAction::class);

    $this->assertDatabaseMissing('products', [
        'id' => $product->id,
    ]);
});

it('prevents creating a product with missing required fields', function (): void {
    Livewire::test(CreateProduct::class)
        ->fillForm([
            'name' => null,
            'unit' => null,
            'price' => null,
        ])
        ->call('create')
        ->assertHasFormErrors([
            'name' => 'required',
            'unit' => 'required',
            'price' => 'required',
        ]);
});

it('filters products by category', function (): void {
    $category = ProductCategory::factory()->create([
        'name' => 'Cimento',
        'slug' => 'cimento',
    ]);

    $categorizedProduct = Product::factory()->for($category, 'productCategory')->create([
        'category' => 'Cimento',
    ]);
    $otherProduct = Product::factory()->create();

    Livewire::test(ListProducts::class)
        ->filterTable('product_category_id', $category->id)
        ->assertCanSeeTableRecords([$categorizedProduct])
        ->assertCanNotSeeTableRecords([$otherProduct]);
});

it('searches products by name', function (): void {
    $matchingProduct = Product::factory()->create([
        'name' => 'Viga estrutural',
    ]);
    $otherProduct = Product::factory()->create([
        'name' => 'Telha colonial',
    ]);

    Livewire::test(ListProducts::class)
        ->searchTable('Viga')
        ->assertCanSeeTableRecords([$matchingProduct])
        ->assertCanNotSeeTableRecords([$otherProduct]);
});
