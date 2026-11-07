<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CollectionResource\Pages;
use App\Modules\Products\Models\Collection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CollectionResource extends Resource
{
    protected static ?string $model = Collection::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static string|\UnitEnum|null $navigationGroup = 'Product';

    protected static ?string $navigationLabel = 'Collections';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Collection Details')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('season')
                        ->options([
                            'SS' => 'Spring/Summer',
                            'AW' => 'Autumn/Winter',
                            'Resort' => 'Resort',
                            'Pre' => 'Pre-Season',
                        ])
                        ->required(),
                    Forms\Components\TextInput::make('year')
                        ->numeric()
                        ->minValue(2020)
                        ->maxValue(2030)
                        ->required(),
                    Forms\Components\Select::make('status')
                        ->options([
                            'planning' => 'Planning',
                            'active' => 'Active',
                            'closed' => 'Closed',
                        ])
                        ->default('planning')
                        ->required(),
                ])->columns(2),
            Forms\Components\Section::make('Description')
                ->schema([
                    Forms\Components\Textarea::make('description')
                        ->rows(4)
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('season')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'SS' => 'Spring/Summer',
                        'AW' => 'Autumn/Winter',
                        'Resort' => 'Resort',
                        'Pre' => 'Pre-Season',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('year')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'planning' => 'warning',
                        'active' => 'success',
                        'closed' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('products_count')
                    ->label('Products')
                    ->counts('products')
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('season')
                    ->options([
                        'SS' => 'Spring/Summer',
                        'AW' => 'Autumn/Winter',
                        'Resort' => 'Resort',
                        'Pre' => 'Pre-Season',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'planning' => 'Planning',
                        'active' => 'Active',
                        'closed' => 'Closed',
                    ]),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('year', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCollections::route('/'),
            'create' => Pages\CreateCollection::route('/create'),
            'view' => Pages\ViewCollection::route('/{record}'),
            'edit' => Pages\EditCollection::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
