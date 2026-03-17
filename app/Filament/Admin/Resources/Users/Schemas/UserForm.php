<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Users\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

use function filled;

final class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make()
                    ->columns()
                    ->schema([
                        Toggle::make('status')
                            ->required()
                            ->autofocus(),
                        TextInput::make('name')
                            ->required()
                            ->string()
                            ->autofocus(),
                        TextInput::make('email')
                            ->required()
                            ->string()
                            ->unique('users', 'email', ignoreRecord: true)
                            ->email(),
                        TextInput::make('password')
                            ->password()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->dehydrated(fn ($state): bool => filled($state))
                            ->minLength(6),
                        CheckboxList::make('roles')
                            ->relationship(
                                name: 'roles',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn (Builder $query): Builder => $query
                                    ->where('guard_name', 'web')
                                    ->orderBy('name'),
                            )
                            ->columns(2)
                            ->searchable(),
                    ]),
            ]);
    }
}
