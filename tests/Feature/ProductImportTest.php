<?php

declare(strict_types=1);

use App\Filament\Admin\Resources\Products\Pages\ListProducts;
use App\Filament\Imports\ProductImporter;
use App\Models\Admin;
use App\Models\Product;
use App\Models\ProductCategory;
use Filament\Actions\ImportAction;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Models\Import;
use Filament\Facades\Filament;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Bus;
use Illuminate\Validation\ValidationException;
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

    $this->admin = $admin;

    $this->actingAs($admin, 'admin');
});

it('configures the import action on the product list page', function (): void {
    Livewire::test(ListProducts::class)
        ->assertActionExists('import', function (ImportAction $action): bool {
            return $action->getImporter() === ProductImporter::class
                && $action->getChunkSize() === 100
                && $action->getMaxRows() === 100000;
        });
});

it('guesses portuguese column names for the product importer', function (): void {
    $columns = collect(ProductImporter::getColumns())
        ->keyBy(fn (ImportColumn $column): string => $column->getName());

    expect($columns->get('internal_code')?->getGuesses())->toContain('codigo', 'cod', 'sku', 'ref');
    expect($columns->get('name')?->getGuesses())->toContain('nome', 'descricao', 'produto', 'material');
    expect($columns->get('unit')?->getGuesses())->toContain('unidade', 'un', 'und');
    expect($columns->get('price')?->getGuesses())->toContain('preco', 'valor', 'preco_unitario');
    expect($columns->get('category')?->getGuesses())->toContain('categoria', 'grupo', 'tipo');
});

it('upserts products by internal code during import', function (): void {
    $category = ProductCategory::factory()->create([
        'name' => 'Cimento',
        'slug' => 'cimento',
    ]);

    Product::factory()->create([
        'internal_code' => 'PRD-0001',
        'name' => 'Produto antigo',
        'unit' => 'un',
        'price' => 10,
        'category' => null,
        'product_category_id' => null,
    ]);

    $importer = new ProductImporter(new Import(), [
        'internal_code' => 'codigo',
        'name' => 'nome',
        'unit' => 'unidade',
        'price' => 'preco',
        'category' => 'categoria',
    ], []);

    $importer([
        'codigo' => 'PRD-0001',
        'nome' => 'Cimento CP-II 50kg',
        'unidade' => 'KG',
        'preco' => '49,90',
        'categoria' => 'Cimento',
    ]);

    $product = Product::query()->where('internal_code', 'PRD-0001')->firstOrFail();

    expect($product->name)->toBe('Cimento CP-II 50kg');
    expect($product->unit)->toBe('kg');
    expect((float) $product->price)->toBe(49.90);
    expect($product->category)->toBe('Cimento');
    expect($product->product_category_id)->toBe($category->id);
    expect(Product::query()->count())->toBe(1);
});

it('rejects invalid rows without saving products', function (): void {
    $importer = new ProductImporter(new Import(), [
        'internal_code' => 'codigo',
        'name' => 'nome',
        'unit' => 'unidade',
        'price' => 'preco',
    ], []);

    expect(fn () => $importer([
        'codigo' => 'PRD-0002',
        'nome' => '',
        'unidade' => 'caixa',
        'preco' => '',
    ]))->toThrow(ValidationException::class);

    expect(Product::query()->count())->toBe(0);
});

it('starts a batched import from the list action', function (): void {
    Bus::fake();

    $file = UploadedFile::fake()->createWithContent(
        'products.csv',
        implode("\n", [
            'codigo,nome,unidade,preco,categoria',
            'PRD-9001,Cimento CP-II 50kg,un,"49,90",Cimento',
        ]),
    );

    Livewire::test(ListProducts::class)
        ->callAction('import', [
            'file' => $file,
            'columnMap' => [
                'internal_code' => 'codigo',
                'name' => 'nome',
                'unit' => 'unidade',
                'price' => 'preco',
                'category' => 'categoria',
            ],
        ])
        ->assertHasNoActionErrors();

    Bus::assertBatched(function ($batch): bool {
        return $batch->name === 'product-import'
            && count($batch->jobs) === 1;
    });

    $this->assertDatabaseHas('imports', [
        'importer' => ProductImporter::class,
        'total_rows' => 1,
        'user_type' => Admin::class,
        'user_id' => $this->admin->id,
    ]);
});
