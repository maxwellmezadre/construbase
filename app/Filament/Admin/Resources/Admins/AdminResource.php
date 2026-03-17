<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Admins;

use App\Filament\Admin\Resources\Admins\Pages\CreateAdmin;
use App\Filament\Admin\Resources\Admins\Pages\EditAdmin;
use App\Filament\Admin\Resources\Admins\Pages\ListAdmins;
use App\Filament\Admin\Resources\Admins\Pages\ViewAdmin;
use App\Filament\Admin\Resources\Admins\Schemas\AdminForm;
use App\Filament\Admin\Resources\Admins\Schemas\AdminInfolist;
use App\Filament\Admin\Resources\Admins\Tables\AdminsTable;
use App\Models\Admin;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Cache;
use Override;

use function __;

final class AdminResource extends Resource
{
    #[Override]
    protected static ?string $model = Admin::class;

    #[Override]
    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserCircle;

    #[Override]
    protected static bool $isGloballySearchable = true;

    #[Override]
    protected static ?string $recordTitleAttribute = 'name';

    #[Override]
    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email'];
    }

    #[Override]
    public static function getGlobalSearchResultUrl($record): string
    {
        return self::getUrl('view', ['record' => $record]);
    }

    #[Override]
    public static function getModelLabel(): string
    {
        return __('Admin');
    }

    #[Override]
    public static function getPluralModelLabel(): string
    {
        return __('Admins');
    }

    #[Override]
    public static function getNavigationLabel(): string
    {
        return __('Admins');
    }

    #[Override]
    public static function getNavigationGroup(): string
    {
        return __('Management');
    }

    public static function getNavigationBadge(): string
    {
        return (string) Cache::rememberForever('admins_count', fn () => Admin::query()->count());
    }

    #[Override]
    public static function form(Schema $schema): Schema
    {
        return AdminForm::configure($schema);
    }

    #[Override]
    public static function infolist(Schema $schema): Schema
    {
        return AdminInfolist::configure($schema);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return AdminsTable::configure($table);
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
            'index' => ListAdmins::route('/'),
            'create' => CreateAdmin::route('/create'),
            'view' => ViewAdmin::route('/{record}'),
            'edit' => EditAdmin::route('/{record}/edit'),
        ];
    }
}
