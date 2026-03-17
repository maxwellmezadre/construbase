<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Products\Schemas;

use App\Filament\Schemas\Components\AdditionalInformation;
use App\Models\Product;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

use function __;

final class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make()
                    ->columns(2)
                    ->schema([
                        TextEntry::make('internal_code')
                            ->label(__('Internal code'))
                            ->placeholder('-'),
                        TextEntry::make('name'),
                        TextEntry::make('unit'),
                        TextEntry::make('price')
                            ->money('BRL'),
                        TextEntry::make('product_category')
                            ->label(__('Category'))
                            ->state(fn (Product $record): string => filled($record->product_category_id) ? $record->productCategory->name : ($record->category ?? '-')),
                        IconEntry::make('is_active')
                            ->label(__('Active'))
                            ->boolean(),
                        TextEntry::make('notes')
                            ->columnSpanFull()
                            ->placeholder('-'),
                    ]),
                AdditionalInformation::make([
                    'created_at',
                    'updated_at',
                ]),
            ]);
    }
}
