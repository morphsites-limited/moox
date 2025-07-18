<?php

namespace Moox\Page\Resources;

use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Moox\Core\Traits\Tabs\HasResourceTabs;
use Moox\Page\Models\Page;
use Moox\Page\Resources\PageResource\Pages\ListPage;
use Moox\Page\Resources\PageResource\Widgets\PageWidgets;
use Override;

class PageResource extends Resource
{
    use HasResourceTabs;

    protected static ?string $model = Page::class;

    protected static string|\BackedEnum|null $navigationIcon = 'gmdi-pages';

    #[Override]
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->maxLength(255),
                DateTimePicker::make('started_at'),
                DateTimePicker::make('finished_at'),
                Toggle::make('failed')
                    ->required(),
            ]);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('page::translations.name'))
                    ->sortable(),
                TextColumn::make('started_at')
                    ->label(__('page::translations.started_at'))
                    ->since()
                    ->sortable(),
                TextColumn::make('failed')
                    ->label(__('page::translations.failed'))
                    ->sortable(),
            ])
            ->defaultSort('name', 'desc')
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
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
            'index' => ListPage::route('/'),
        ];
    }

    #[Override]
    public static function getWidgets(): array
    {
        return [
            PageWidgets::class,
        ];
    }

    #[Override]
    public static function getModelLabel(): string
    {
        return __('page::translations.single');
    }

    #[Override]
    public static function getPluralModelLabel(): string
    {
        return __('page::translations.plural');
    }

    #[Override]
    public static function getNavigationLabel(): string
    {
        return __('page::translations.navigation_label');
    }

    #[Override]
    public static function getNavigationGroup(): ?string
    {
        return __('page::translations.navigation_group');
    }

    #[Override]
    public static function getBreadcrumb(): string
    {
        return __('page::translations.breadcrumb');
    }
}
