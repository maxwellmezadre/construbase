<?php

declare(strict_types=1);

namespace App\Providers;

use App\Providers\Filament\AdminPanelProvider;
use App\Providers\Filament\AppPanelProvider;
use App\Providers\Filament\GuestPanelProvider;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\Entry;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Support\Facades\FilamentView;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;
use Override;

use function view;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    #[Override]
    public function register(): void
    {
        if (config('filakit.admin_panel_enabled', false)) {
            $this->app->register(AdminPanelProvider::class);
        }

        if (config('filakit.app_panel_enabled', false)) {
            $this->app->register(AppPanelProvider::class);
        }

        if (config('filakit.guest_panel_enabled', false)) {
            $this->app->register(GuestPanelProvider::class);
        }

        if (config('filakit.favicon.enabled')) {
            FilamentView::registerRenderHook(PanelsRenderHook::HEAD_START, fn (): View => view('components.favicon'));
        }

        FilamentView::registerRenderHook(PanelsRenderHook::HEAD_START, fn (): View => view('components.js-md5'));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (! app()->isLocal()) {
            URL::forceHttps();
            Vite::useAggressivePrefetching();
        }

        Model::automaticallyEagerLoadRelationships();

        $this->configureActions();
        $this->configureSchema();
        $this->configureForms();
        $this->configureInfolists();
        $this->configurePages();
        $this->configureTables();
    }

    private function configureActions(): void
    {
        ActionGroup::configureUsing(function (ActionGroup $action): ActionGroup {
            return $action->icon(Heroicon::EllipsisVertical);
        });

        Action::configureUsing(function (Action $action): Action {
            return $action
                ->translateLabel()
                ->modalWidth(Width::Medium)
                ->closeModalByClickingAway(false);
        });

        CreateAction::configureUsing(function (CreateAction $action): CreateAction {
            return $action
                ->icon(Heroicon::Plus)
                ->hiddenLabel()
                ->createAnother(false);
        });

        EditAction::configureUsing(function (EditAction $action): EditAction {
            return $action
                ->icon(Heroicon::PencilSquare)
                ->hiddenLabel()
                ->button();
        });

        DeleteAction::configureUsing(function (DeleteAction $action): DeleteAction {
            return $action
                ->icon(Heroicon::Trash)
                ->hiddenLabel()
                ->button();
        });

        ViewAction::configureUsing(function (ViewAction $action): ViewAction {
            return $action
                ->icon(Heroicon::Eye)
                ->hiddenLabel()
                ->button();
        });
    }

    private function configureSchema(): void
    {
        Schema::configureUsing(function (Schema $schema): Schema {
            return $schema
                ->defaultCurrency(config('filakit.defaultCurrency'))
                ->defaultDateDisplayFormat(config('filakit.defaultDateDisplayFormat'))
                ->defaultIsoDateDisplayFormat(config('filakit.defaultIsoDateDisplayFormat'))
                ->defaultDateTimeDisplayFormat(config('filakit.defaultDateTimeDisplayFormat'))
                ->defaultIsoDateTimeDisplayFormat(config('filakit.defaultIsoDateTimeDisplayFormat'))
                ->defaultNumberLocale(config('filakit.defaultNumberLocale'))
                ->defaultTimeDisplayFormat(config('filakit.defaultTimeDisplayFormat'))
                ->defaultIsoTimeDisplayFormat(config('filakit.defaultIsoTimeDisplayFormat'));
        });
    }

    private function configureForms(): void
    {
        Field::configureUsing(function (Field $field): Field {
            return $field->translateLabel();
        });

        ToggleButtons::configureUsing(function (ToggleButtons $component): ToggleButtons {
            return $component
                ->inline()
                ->grouped();
        });

        TextInput::configureUsing(function (TextInput $component): TextInput {
            return $component->minValue(0);
        });

        Select::configureUsing(function (Select $component): Select {
            return $component
                ->native(false)
                ->selectablePlaceholder(function (Select $component): bool {
                    return ! $component->isRequired();
                })
                ->searchable(function (Select $component): bool {
                    return $component->hasRelationship();
                })
                ->preload(function (Select $component): bool {
                    return $component->isSearchable();
                });
        });

        DateTimePicker::configureUsing(function (DateTimePicker $component): DateTimePicker {
            return $component
                ->seconds(false)
                ->maxDate('9999-12-31T23:59');
        });

        Repeater::configureUsing(function (Repeater $component): Repeater {
            return $component->deleteAction(function (Action $action): Action {
                return $action->requiresConfirmation();
            });
        });

        Builder::configureUsing(function (Builder $component): Builder {
            return $component->deleteAction(function (Action $action): Action {
                return $action->requiresConfirmation();
            });
        });

        FileUpload::configureUsing(function (FileUpload $component): FileUpload {
            return $component->moveFiles();
        });

        Textarea::configureUsing(function (Textarea $component): Textarea {
            return $component->rows(4);
        });
    }

    private function configureInfolists(): void
    {
        Entry::configureUsing(function (Entry $entry): Entry {
            return $entry->translateLabel();
        });
    }

    private function configurePages(): void
    {
        Page::$reportValidationErrorUsing = function (ValidationException $exception): void {
            Notification::make()
                ->title($exception->getMessage())
                ->danger()
                ->send();
        };

        Page::$formActionsAreSticky = false;
    }

    private function configureTables(): void
    {
        Table::configureUsing(function (Table $table): Table {
            return $table
                ->defaultCurrency(config('filakit.defaultCurrency'))
                ->defaultDateDisplayFormat(config('filakit.defaultDateDisplayFormat'))
                ->defaultIsoDateDisplayFormat(config('filakit.defaultIsoDateDisplayFormat'))
                ->defaultDateTimeDisplayFormat(config('filakit.defaultDateTimeDisplayFormat'))
                ->defaultIsoDateTimeDisplayFormat(config('filakit.defaultIsoDateTimeDisplayFormat'))
                ->defaultNumberLocale(config('filakit.defaultNumberLocale'))
                ->defaultTimeDisplayFormat(config('filakit.defaultTimeDisplayFormat'))
                ->defaultIsoTimeDisplayFormat(config('filakit.defaultIsoTimeDisplayFormat'));
        });
        Column::configureUsing(function (Column $column): Column {
            return $column->translateLabel();
        });

        Table::configureUsing(function (Table $table): Table {
            return $table
                ->filtersFormWidth('md')
                ->paginationPageOptions([5, 10, 25, 50]);
        });

        ImageColumn::configureUsing(function (ImageColumn $column): ImageColumn {
            return $column->extraImgAttributes(['loading' => 'lazy']);
        });

        SelectFilter::configureUsing(function (SelectFilter $filter): SelectFilter {
            return $filter->native(false);
        });
    }
}
