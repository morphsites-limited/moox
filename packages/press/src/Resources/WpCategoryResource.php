<?php

namespace Moox\Press\Resources;

use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Moox\Core\Traits\Base\BaseInResource;
use Moox\Core\Traits\Tabs\HasResourceTabs;
use Moox\Press\Models\WpCategory;
use Moox\Press\Models\WpTerm;
use Moox\Press\Resources\WpCategoryResource\Pages\CreateWpCategory;
use Moox\Press\Resources\WpCategoryResource\Pages\EditWpCategory;
use Moox\Press\Resources\WpCategoryResource\Pages\ListWpCategories;
use Moox\Press\Resources\WpCategoryResource\Pages\ViewWpCategory;
use Override;

class WpCategoryResource extends Resource
{
    use BaseInResource;
    use HasResourceTabs;

    protected static ?string $model = WpCategory::class;

    protected static string|\BackedEnum|null $navigationIcon = 'gmdi-category';

    protected static ?string $recordTitleAttribute = 'name';

    #[Override]
    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->schema([
                Grid::make(['default' => 0])->schema([
                    TextInput::make('name')
                        ->label(__('core::core.name'))
                        ->rules(['max:200', 'string'])
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('slug')
                        ->label(__('core::core.slug'))
                        ->rules(['max:200', 'string'])
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Textarea::make('description')
                        ->label(__('core::core.description'))
                        ->rules(['string'])
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('parent')
                        ->label(__('core::core.parent'))
                        ->options(fn () => (new WpTerm)->pluck('name', 'term_id'))
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('term_group')
                        ->rules(['integer'])
                        ->label(__('core::core.term_group'))
                        ->required()
                        ->default('0')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('count')
                        ->rules(['integer'])
                        ->label(__('core::core.count'))
                        ->required()
                        ->readonly()
                        ->default('0')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                ]),
            ]),
        ]);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return $table
            ->poll('60s')
            ->columns([
                TextColumn::make('name')
                    ->label(__('core::core.name'))
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                TextColumn::make('slug')
                    ->label(__('core::core.slug'))
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                TextColumn::make('description')
                    ->label(__('core::core.description'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->limit(50),
                TextColumn::make('parent')
                    ->label(__('core::core.parent'))
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('count')
                    ->label(__('core::core.count'))
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('term_group')
                    ->label(__('core::core.term_group'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->limit(50),
            ])
            ->recordActions([ViewAction::make(), EditAction::make()])
            ->toolbarActions([DeleteBulkAction::make()]);
    }

    #[Override]
    public static function getRelations(): array
    {
        return [];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListWpCategories::route('/'),
            'create' => CreateWpCategory::route('/create'),
            'view' => ViewWpCategory::route('/{record}'),
            'edit' => EditWpCategory::route('/{record}/edit'),
        ];
    }

    #[Override]
    public static function getModelLabel(): string
    {
        return config('press.resources.category.single');
    }

    #[Override]
    public static function getPluralModelLabel(): string
    {
        return config('press.resources.category.plural');
    }

    #[Override]
    public static function getNavigationLabel(): string
    {
        return config('press.resources.category.plural');
    }

    #[Override]
    public static function getBreadcrumb(): string
    {
        return config('press.resources.category.single');
    }

    #[Override]
    public static function getNavigationGroup(): ?string
    {
        return config('press.press_navigation_group');
    }
}
