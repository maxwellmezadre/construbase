<?php

declare(strict_types=1);

namespace App\Filament\Imports;

use App\Models\Product;
use App\Models\ProductCategory;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;
use Illuminate\Support\Str;
use Override;

final class ProductImporter extends Importer
{
    #[Override]
    protected static ?string $model = Product::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('internal_code')
                ->label('Codigo interno')
                ->example('PRD-1001')
                ->requiredMapping()
                ->guess(['codigo', 'cod', 'sku', 'ref'])
                ->rules(['required', 'max:255']),
            ImportColumn::make('name')
                ->label('Nome')
                ->example('Cimento CP-II 50kg')
                ->requiredMapping()
                ->guess(['nome', 'descricao', 'produto', 'material'])
                ->rules(['required', 'max:255']),
            ImportColumn::make('unit')
                ->label('Unidade')
                ->example('un')
                ->requiredMapping()
                ->guess(['unidade', 'un', 'und'])
                ->castStateUsing(fn (?string $state): ?string => filled($state) ? Str::lower(mb_trim($state)) : null)
                ->rules(['required', 'in:m2,un,kg,m,litro']),
            ImportColumn::make('price')
                ->label('Preco')
                ->example('49,90')
                ->requiredMapping()
                ->guess(['preco', 'valor', 'preco_unitario'])
                ->castStateUsing(function (mixed $state, mixed $originalState): ?float {
                    if (blank($originalState)) {
                        return null;
                    }

                    $normalizedState = preg_replace('/[^0-9,.-]/', '', (string) $originalState) ?? '';

                    if (str_contains($normalizedState, ',')) {
                        $normalizedState = str_replace('.', '', $normalizedState);
                        $normalizedState = str_replace(',', '.', $normalizedState);
                    }

                    if (in_array($normalizedState, ['', '-', '.'], true)) {
                        return null;
                    }

                    return round((float) $normalizedState, 2);
                })
                ->rules(['required', 'numeric', 'min:0']),
            ImportColumn::make('category')
                ->label('Categoria')
                ->example('Cimento')
                ->guess(['categoria', 'grupo', 'tipo'])
                ->ignoreBlankState()
                ->rules(['nullable', 'max:255']),
        ];
    }

    #[Override]
    public static function getCompletedNotificationTitle(Import $import): string
    {
        return 'Importacao de produtos concluida';
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'A importacao de produtos foi concluida com '.Number::format($import->successful_rows).' '.str('linha')->plural($import->successful_rows).' importada.';

        if (($failedRowsCount = $import->getFailedRowsCount()) !== 0) {
            $body .= ' '.Number::format($failedRowsCount).' '.str('linha')->plural($failedRowsCount).' falhou.';
        }

        return $body;
    }

    #[Override]
    public function resolveRecord(): Product
    {
        $internalCode = mb_trim((string) ($this->data['internal_code'] ?? ''));

        if ($internalCode === '') {
            return new Product([
                'is_active' => true,
            ]);
        }

        return Product::query()->firstOrNew(
            ['internal_code' => $internalCode],
            ['is_active' => true],
        );
    }

    public function getJobBatchName(): string
    {
        return 'product-import';
    }

    #[Override]
    public function getValidationMessages(): array
    {
        return [
            'internal_code.required' => 'O codigo interno e obrigatorio.',
            'name.required' => 'O nome do produto e obrigatorio.',
            'unit.required' => 'A unidade e obrigatoria.',
            'unit.in' => 'A unidade deve ser uma das opcoes suportadas: m2, un, kg, m ou litro.',
            'price.required' => 'O preco e obrigatorio.',
            'price.numeric' => 'O preco precisa ser numerico.',
        ];
    }

    protected function beforeSave(): void
    {
        /** @var Product $product */
        $product = $this->record;
        $categoryName = filled($product->category) ? mb_trim((string) $product->category) : null;

        $product->category = $categoryName;
        $product->product_category_id = $this->resolveCategoryId($categoryName);
        $product->is_active ??= true;
    }

    private function resolveCategoryId(?string $categoryName): ?int
    {
        if (blank($categoryName)) {
            return null;
        }

        return ProductCategory::query()
            ->whereRaw('LOWER(name) = ?', [Str::lower($categoryName)])
            ->value('id');
    }
}
