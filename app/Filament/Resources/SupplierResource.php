<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupplierResource\Pages;
use App\Modules\Suppliers\Models\Supplier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationGroup = 'Supply Chain';

    protected static ?string $navigationLabel = 'Suppliers';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Basic Info')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('code')
                        ->maxLength(100)
                        ->unique(ignoreRecord: true),
                    Forms\Components\Select::make('type')
                        ->options([
                            'fabric' => 'Fabric Supplier',
                            'trim' => 'Trim Supplier',
                            'factory' => 'Factory',
                            'logistics' => 'Logistics',
                            'other' => 'Other',
                        ])
                        ->required(),
                    Forms\Components\Select::make('status')
                        ->options([
                            'active' => 'Active',
                            'inactive' => 'Inactive',
                            'blacklisted' => 'Blacklisted',
                        ])
                        ->default('active')
                        ->required(),
                ])->columns(2),
            Forms\Components\Section::make('Contact Info')
                ->schema([
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('phone')
                        ->tel()
                        ->maxLength(50),
                    Forms\Components\TextInput::make('website')
                        ->url()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('country')
                        ->maxLength(100),
                    Forms\Components\TextInput::make('city')
                        ->maxLength(100),
                    Forms\Components\Textarea::make('address')
                        ->rows(3)
                        ->columnSpanFull(),
                ])->columns(2),
            Forms\Components\Section::make('Commercial')
                ->schema([
                    Forms\Components\TextInput::make('currency')
                        ->maxLength(10)
                        ->default('USD'),
                    Forms\Components\TextInput::make('payment_terms')
                        ->maxLength(255)
                        ->placeholder('e.g. Net 30'),
                    Forms\Components\TextInput::make('rating')
                        ->numeric()
                        ->minValue(1)
                        ->maxValue(5)
                        ->step(0.5),
                ])->columns(3),
            Forms\Components\Section::make('Contacts')
                ->schema([
                    Forms\Components\Repeater::make('contacts')
                        ->relationship('contacts')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('title')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('email')
                                ->email()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('phone')
                                ->tel()
                                ->maxLength(50),
                            Forms\Components\Toggle::make('is_primary')
                                ->label('Primary Contact')
                                ->default(false),
                        ])
                        ->columns(2)
                        ->addActionLabel('Add Contact')
                        ->collapsible()
                        ->defaultItems(0),
                ]),
            Forms\Components\Section::make('Notes')
                ->schema([
                    Forms\Components\Textarea::make('notes')
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
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'fabric' => 'Fabric Supplier',
                        'trim' => 'Trim Supplier',
                        'factory' => 'Factory',
                        'logistics' => 'Logistics',
                        default => ucfirst($state),
                    })
                    ->color('info'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'warning',
                        'blacklisted' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('country')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('rating')
                    ->formatStateUsing(fn ($state) => $state ? number_format((float) $state, 1) . ' ★' : '—')
                    ->sortable(),
                Tables\Columns\TextColumn::make('contacts_count')
                    ->label('Contacts')
                    ->counts('contacts')
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'fabric' => 'Fabric Supplier',
                        'trim' => 'Trim Supplier',
                        'factory' => 'Factory',
                        'logistics' => 'Logistics',
                        'other' => 'Other',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'blacklisted' => 'Blacklisted',
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
            ->defaultSort('name', 'asc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuppliers::route('/'),
            'create' => Pages\CreateSupplier::route('/create'),
            'view' => Pages\ViewSupplier::route('/{record}'),
            'edit' => Pages\EditSupplier::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
