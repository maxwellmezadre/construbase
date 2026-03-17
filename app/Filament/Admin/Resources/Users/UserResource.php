<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Users;

use App\Filament\Admin\Resources\Users\Pages\CreateUser;
use App\Filament\Admin\Resources\Users\Pages\EditUser;
use App\Filament\Admin\Resources\Users\Pages\ListUsers;
use App\Filament\Admin\Resources\Users\Pages\ViewUser;
use App\Filament\Admin\Resources\Users\Schemas\UserForm;
use App\Filament\Admin\Resources\Users\Schemas\UserInfolist;
use App\Filament\Admin\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Cache;
use Override;

use function __;

final class UserResource extends Resource
{
    #[Override]
    protected static ?string $model = User::class;

    #[Override]
    protected static string|BackedEnum|null $navigationIcon = Heroicon::User;

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
        return __('User');
    }

    #[Override]
    public static function getPluralModelLabel(): string
    {
        return __('Users');
    }

    #[Override]
    public static function getNavigationLabel(): string
    {
        return __('Users');
    }

    #[Override]
    public static function getNavigationGroup(): string
    {
        return __('User');
    }

    public static function getNavigationBadge(): string
    {
        return (string) Cache::rememberForever('users_count', fn () => User::query()->count());
    }

    #[Override]
    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    #[Override]
    public static function infolist(Schema $schema): Schema
    {
        return UserInfolist::configure($schema);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'view' => ViewUser::route('/{record}'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
