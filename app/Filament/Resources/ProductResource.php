<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Modules\Products\Models\Collection;
use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\ProductCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static string|\UnitEnum|null $navigationGroup = 'Product';

    protected static ?string $navigationLabel = 'Products';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Product Identity')
                ->schema([
                    Forms\Components\TextInput::make('style_number')
                        ->label('Style Number')
                        ->required()
                        ->maxLength(100)
                        ->unique(ignoreRecord: true),
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('category_id')
                        ->label('Category')
                        ->options(ProductCategory::withoutTenantScope()->pluck('name', 'id'))
                        ->searchable()
                        ->preload(),
                    Forms\Components\Select::make('collection_id')
                        ->label('Collection')
                        ->options(Collection::withoutTenantScope()->pluck('name', 'id'))
                        ->searchable()
                        ->preload(),
                ])->columns(2),
            Forms\Components\Section::make('Classification')
                ->schema([
                    Forms\Components\Select::make('type')
                        ->options([
                            'garment' => 'Garment',
                            'footwear' => 'Footwear',
                            'accessory' => 'Accessory',
                            'bag' => 'Bag',
                            'other' => 'Other',
                        ])
                        ->required()
                        ->default('garment'),
                    Forms\Components\Select::make('gender')
                        ->options([
                            'men' => 'Men',
                            'women' => 'Women',
                            'kids' => 'Kids',
                            'unisex' => 'Unisex',
                        ])
                        ->default('unisex'),
                    Forms\Components\TextInput::make('season')
                        ->maxLength(50)
                        ->placeholder('SS25, AW24...'),
                    Forms\Components\Select::make('status')
                        ->options([
                            'draft' => 'Draft',
                            'active' => 'Active',
                            'development' => 'In Development',
                            'sampling' => 'Sampling',
                            'production' => 'Production',
                            'archived' => 'Archived',
                        ])
                        ->default('draft')
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
                Tables\Columns\TextColumn::make('style_number')
                    ->label('Style #')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable()
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => ucfirst($state))
                    ->color(fn (string $state): string => match ($state) {
                        'garment' => 'primary',
                        'footwear' => 'warning',
                        'accessory' => 'success',
                        'bag' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('gender')
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(fn ($state) => ucfirst($state ?? '')),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'active' => 'success',
                        'development' => 'warning',
                        'sampling' => 'info',
                        'production' => 'primary',
                        'archived' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('collection.name')
                    ->label('Collection')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'active' => 'Active',
                        'development' => 'In Development',
                        'sampling' => 'Sampling',
                        'production' => 'Production',
                        'archived' => 'Archived',
                    ]),
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'garment' => 'Garment',
                        'footwear' => 'Footwear',
                        'accessory' => 'Accessory',
                        'bag' => 'Bag',
                        'other' => 'Other',
                    ]),
                Tables\Filters\SelectFilter::make('gender')
                    ->options([
                        'men' => 'Men',
                        'women' => 'Women',
                        'kids' => 'Kids',
                        'unisex' => 'Unisex',
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
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
