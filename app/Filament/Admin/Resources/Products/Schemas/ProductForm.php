<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Products\Schemas;

use App\Models\ProductCategory;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

use function __;

final class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make()
                    ->columns(2)
                    ->schema([
                        TextInput::make('internal_code')
                            ->label(__('Internal code'))
                            ->maxLength(255),
                        TextInput::make('name')
                            ->required()
                            ->string()
                            ->maxLength(255),
                        Select::make('unit')
                            ->required()
                            ->options([
                                'm2' => 'm2',
                                'un' => 'un',
                                'kg' => 'kg',
                                'm' => 'm',
                                'litro' => 'litro',
                            ])
                            ->native(false),
                        TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('R$'),
                        Select::make('product_category_id')
                            ->label(__('Category'))
                            ->relationship('productCategory', 'name')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function (Set $set, ?int $state): void {
                                $set('category', ProductCategory::query()->find($state)?->name);
                            }),
                        Toggle::make('is_active')
                            ->label(__('Active'))
                            ->default(true)
                            ->required(),
                        Textarea::make('notes')
                            ->columnSpanFull()
                            ->rows(4),
                        Hidden::make('category'),
                    ]),
            ]);
    }
}
