<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Products;

use App\Filament\Admin\Resources\Products\Pages\CreateProduct;
use App\Filament\Admin\Resources\Products\Pages\EditProduct;
use App\Filament\Admin\Resources\Products\Pages\ListProducts;
use App\Filament\Admin\Resources\Products\Pages\ViewProduct;
use App\Filament\Admin\Resources\Products\Schemas\ProductForm;
use App\Filament\Admin\Resources\Products\Schemas\ProductInfolist;
use App\Filament\Admin\Resources\Products\Tables\ProductsTable;
use App\Models\Product;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Override;

use function __;

final class ProductResource extends Resource
{
    #[Override]
    protected static ?string $model = Product::class;

    #[Override]
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    #[Override]
    protected static bool $isGloballySearchable = true;

    #[Override]
    protected static ?string $recordTitleAttribute = 'name';

    #[Override]
    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'internal_code'];
    }

    #[Override]
    public static function getGlobalSearchResultUrl($record): string
    {
        return self::getUrl('view', ['record' => $record]);
    }

    #[Override]
    public static function getModelLabel(): string
    {
        return __('Product');
    }

    #[Override]
    public static function getPluralModelLabel(): string
    {
        return __('Products');
    }

    #[Override]
    public static function getNavigationLabel(): string
    {
        return __('Products');
    }

    #[Override]
    public static function getNavigationGroup(): string
    {
        return __('Management');
    }

    public static function getNavigationBadge(): string
    {
        return (string) Product::query()->count();
    }

    #[Override]
    public static function form(Schema $schema): Schema
    {
        return ProductForm::configure($schema);
    }

    #[Override]
    public static function infolist(Schema $schema): Schema
    {
        return ProductInfolist::configure($schema);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return ProductsTable::configure($table);
    }

    #[Override]
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'view' => ViewProduct::route('/{record}'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }
}
