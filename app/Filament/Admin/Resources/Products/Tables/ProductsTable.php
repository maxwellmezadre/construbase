<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Products\Tables;

use App\Models\Product;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

use function __;

final class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                IconColumn::make('is_active')
                    ->label(__('Active'))
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-mark')
                    ->sortable(),
                TextColumn::make('internal_code')
                    ->label(__('Internal code'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('unit')
                    ->sortable(),
                TextColumn::make('price')
                    ->money('BRL')
                    ->sortable(),
                TextColumn::make('product_category')
                    ->label(__('Category'))
                    ->state(fn (Product $record): string => filled($record->product_category_id) ? $record->productCategory->name : ($record->category ?? '-'))
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('product_category_id')
                    ->label(__('Category'))
                    ->relationship('productCategory', 'name')
                    ->searchable()
                    ->preload(),
                TernaryFilter::make('is_active')
                    ->label(__('Status')),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('activate')
                        ->label(__('Activate'))
                        ->icon('heroicon-o-check-badge')
                        ->color('success')
                        ->action(function (Collection $records): void {
                            $records->each(function ($record): void {
                                $record->update(['is_active' => true]);
                            });
                        }),
                    BulkAction::make('deactivate')
                        ->label(__('Deactivate'))
                        ->icon('heroicon-o-x-mark')
                        ->color('warning')
                        ->action(function (Collection $records): void {
                            $records->each(function ($record): void {
                                $record->update(['is_active' => false]);
                            });
                        }),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
