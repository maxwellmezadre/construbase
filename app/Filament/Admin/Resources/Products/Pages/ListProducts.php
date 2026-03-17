<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Products\Pages;

use App\Filament\Admin\Resources\Products\ProductResource;
use App\Filament\Imports\ProductImporter;
use Filament\Actions\CreateAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use Override;

final class ListProducts extends ListRecords
{
    #[Override]
    protected static string $resource = ProductResource::class;

    #[Override]
    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Todos'),
            'active' => Tab::make('Ativos')
                ->badgeColor('success')
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->where('is_active', true)),
            'uncategorized' => Tab::make('Sem categoria')
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->whereNull('product_category_id')),
        ];
    }

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make()
                ->importer(ProductImporter::class)
                ->chunkSize(100)
                ->maxRows(100000),
            CreateAction::make(),
        ];
    }
}
