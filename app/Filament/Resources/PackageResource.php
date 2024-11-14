<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageResource\Pages;
use App\Filament\Resources\PackageResource\RelationManagers;
use App\Models\Package;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontFamily;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?string $navigationGroup = 'Manage';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                Group::make()
                    ->columnSpan(['lg' => 2])
                    ->schema([
                    Section::make('Package Information')
                        ->columns(2)
                        ->schema([
                            Forms\Components\TextInput::make('uuid')
                                ->label('UUID')
                                ->disabled()
                                ->required()
                                ->hiddenOn('create')
                                ->maxLength(36),
                            Forms\Components\TextInput::make('tracking_code')
                                ->required()
                                ->disabled()
                                ->hiddenOn('create')
                                ->maxLength(255),
                            Forms\Components\Select::make('commune_id')
                                ->relationship('commune', 'name')
                                ->native(false)
                                ->preload()
                                ->searchable()
                                ->required(),
                            Forms\Components\Select::make('store_id')
                                ->relationship('store', 'name')
                                ->native(false)
                                ->preload()
                                ->searchable()
                                ->required(),
                            Forms\Components\Select::make('delivery_type_id')
                                ->relationship('deliveryType', 'name')
                                ->native(false)
                                ->preload()
                                ->searchable()
                                ->required(),
                            Forms\Components\Select::make('status_id')
                                ->relationship('status', 'name')
                                ->native(false)
                                ->preload()
                                ->searchable()
                                ->required(),
                            Forms\Components\TextInput::make('name')
                                ->label('Package name')
                                ->maxLength(255)
                                ->default(null),
                            Forms\Components\TextInput::make('address')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('weight')
                                ->required()
                                ->numeric()
                                ->default(1000),
                        ]),
                    Section::make('Delivery Information')
                        ->columns(3)
                        ->schema([
                            Forms\Components\TextInput::make('cod_to_pay')
                                ->required()
                                ->numeric()
                                ->prefix('$')
                                ->default(0),
                            Forms\Components\TextInput::make('commission')
                                ->required()
                                ->numeric()
                                ->prefix('$')
                                ->default(0),
                            Forms\Components\TextInput::make('delivery_price')
                                ->required()
                                ->prefix('$')
                                ->numeric()
                                ->default(0),
                            Forms\Components\TextInput::make('extra_weight_price')
                                ->required()
                                ->numeric()
                                ->prefix('$')
                                ->default(0),
                            Forms\Components\TextInput::make('packaging_price')
                                ->required()
                                ->numeric()
                                ->prefix('$')
                                ->default(0),
                            Forms\Components\TextInput::make('partner_cod_price')
                                ->required()
                                ->numeric()
                                ->prefix('$')
                                ->default(0),
                            Forms\Components\TextInput::make('partner_delivery_price')
                                ->required()
                                ->numeric()
                                ->prefix('$')
                                ->default(0),
                            Forms\Components\TextInput::make('partner_return')
                                ->required()
                                ->numeric()
                                ->prefix('$')
                                ->default(0),
                            Forms\Components\TextInput::make('price')
                                ->required()
                                ->numeric()
                                ->prefix('$')
                                ->default(0),
                            Forms\Components\TextInput::make('price_to_pay')
                                ->required()
                                ->numeric()
                                ->prefix('$')
                                ->default(0),
                            Forms\Components\TextInput::make('return_price')
                                ->required()
                                ->numeric()
                                ->prefix('$')
                                ->default(0),
                            Forms\Components\TextInput::make('total_price')
                                ->required()
                                ->numeric()
                                ->prefix('$')
                                ->default(0),
                            Forms\Components\DateTimePicker::make('status_updated_at'),
                            Forms\Components\DateTimePicker::make('delivered_at'),
                        ]),
                ]),
                Group::make()
                    ->columnSpan(['lg' => 1])
                    ->schema([
                    Section::make('Package Options')
                        ->schema([
                            Forms\Components\Toggle::make('can_be_opened')
                                ->required(),
                            Forms\Components\Toggle::make('free_delivery')
                                ->required(),
                        ]),
                    Section::make('Client Information')
                        ->columns(1)
                        ->schema([
                            Forms\Components\TextInput::make('client_first_name')
                                ->label('First name')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('client_last_name')
                                ->label('Last name')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('client_phone')
                                ->label('Phone')
                                ->tel()
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('client_phone2')
                                ->label('Phone (Secondary)')
                                ->tel()
                                ->maxLength(255)
                                ->default(null),
                        ]),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('uuid')
                    ->label('UUID')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('tracking_code')
                    ->fontFamily(FontFamily::Mono)
                    ->searchable(),
                Tables\Columns\TextColumn::make('store.name')
                    ->searchable()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Package Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('commune.wilaya.name')
                    ->description(fn($record) => $record->commune->name)
                    ->sortable(),
                Tables\Columns\TextColumn::make('commune.name')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('client_full_name')
                    ->searchable(['client_first_name', 'client_last_name']),
                // Tables\Columns\TextColumn::make('client_last_name')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('client_phone')
                    ->description(fn($record) => $record->client_phone2)
                    ->searchable(),
                // Tables\Columns\TextColumn::make('client_phone2')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('status.name')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Prêt pour le ramassage' => 'purple',
                        'Récupéré'               => 'emerald',
                        'En Attente'             => 'amber',
                        'En Transit'             => 'fuschia',
                        'En Cours de livraison'  => 'blue',
                        'Tentative de livraison' => 'cyan',
                        'Retour à l\'expediteur' => 'danger',
                        'Livré'                  => 'green',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('deliveryType.name')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Domicile'        => 'green',
                        'Express'         => 'danger',
                        'Point de relais' => 'amber',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'Domicile'        => 'heroicon-o-home',
                        'Express'         => 'heroicon-o-paper-airplane',
                        'Point de relais' => 'heroicon-o-map-pin',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('address')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\IconColumn::make('can_be_opened')
                    ->boolean(),
                Tables\Columns\TextColumn::make('cod_to_pay')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->money()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('commission')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->money()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('delivery_price')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('extra_weight_price')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('free_delivery')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),
                Tables\Columns\TextColumn::make('packaging_price')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('partner_cod_price')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('partner_delivery_price')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('partner_return')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price_to_pay')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->money()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('return_price')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->money()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->money()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('weight')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status_updated_at')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('delivered_at')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                ExportBulkAction::make()
                    ->label('Exporter vers Excel')
                    ->exports([
                        ExcelExport::make()
                            ->label('xslx')
                            ->askForWriterType()
                            ->queue()
                            ->withChunkSize(500)
                            ->withFilename('Packages-export-'.date('Y-m-d H-i'))
                            ->withColumns([
                                Column::make('tracking_code')->heading('Tracking Code'),
                                Column::make('store.name')->heading('Store'),
                                Column::make('name')->heading('Package name'),
                                Column::make('client_full_name')->heading('Client fullname'),
                                Column::make('client_phone')->heading('Client phone'),
                                Column::make('commune.wilaya.name')->heading('Wilaya'),
                                Column::make('commune.name')->heading('Commune'),
                                Column::make('deliveryType.name')->heading('Delivery Type'),
                                Column::make('status.name')->heading('Status'),
                            ]),
                    ]),
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPackages::route('/'),
            'create' => Pages\CreatePackage::route('/create'),
            'edit' => Pages\EditPackage::route('/{record}/edit'),
        ];
    }
}
