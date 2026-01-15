<?php

namespace Packages\Automotive\Garage\Filament\Resources\CustomerResource\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Packages\Automotive\Garage\Filament\Resources\CarBrandResource\Schemas\CarBrandForm;
use Packages\Automotive\Garage\Filament\Resources\CarModelResource\Schemas\CarModelForm;

class VehiclesRelationManager extends RelationManager
{
    protected static string $relationship = 'vehicles';

    public static function getTitle(\Illuminate\Database\Eloquent\Model $ownerRecord, string $pageClass): string
    {
        return __('automotive::vehicles.vehicles');
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            // Section 1: Vehicle Identification (excluding customer_id)
            Grid::make(2)->schema([
                // Virtual field for car brand selection (cascading select pattern)
                Select::make('car_brand_id')
                    ->label(__('automotive::vehicles.car_brand'))
                    ->relationship('carModel.carBrand', 'name')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->dehydrated(false) // Don't save to database
                    ->afterStateUpdated(function (Set $set) {
                        // Clear car model when brand changes
                        $set('car_model_id', null);
                    })
                    ->manageOptionForm(fn (Schema $schema) => CarBrandForm::configure($schema))
                    ->columnSpan(1),

                // Actual car_model_id field (filtered by brand)
                Select::make('car_model_id')
                    ->label(__('automotive::vehicles.car_model'))
                    ->relationship('carModel', 'name', fn ($query, Get $get) => $query
                        ->where('car_brand_id', $get('car_brand_id'))
                        ->where('is_active', true))
                    ->searchable()
                    ->required()
                    ->visible(fn (Get $get) => filled($get('car_brand_id')))
                    ->manageOptionForm(fn (Schema $schema) => CarModelForm::configure($schema))
                    ->columnSpan(1),
            ]),

            Grid::make(2)->schema([
                TextInput::make('license_plate')
                    ->label(__('automotive::vehicles.license_plate'))
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->columnSpan(1),

                TextInput::make('vin')
                    ->label(__('automotive::vehicles.vin'))
                    ->maxLength(255)
                    ->placeholder(__('automotive::vehicles.vin_placeholder'))
                    ->columnSpan(1),
            ]),

            // Section 2: Technical Details
            Grid::make(3)->schema([
                TextInput::make('color')
                    ->label(__('automotive::vehicles.color'))
                    ->maxLength(255)
                    ->columnSpan(1),

                TextInput::make('year')
                    ->label(__('automotive::vehicles.year'))
                    ->numeric()
                    ->minValue(1900)
                    ->maxValue(2100)
                    ->placeholder('2020')
                    ->columnSpan(1),

                TextInput::make('mileage')
                    ->label(__('automotive::vehicles.mileage'))
                    ->numeric()
                    ->minValue(0)
                    ->suffix('km')
                    ->placeholder('50000')
                    ->columnSpan(1),
            ]),

            Grid::make(2)->schema([
                Select::make('fuel_type')
                    ->label(__('automotive::vehicles.fuel_type'))
                    ->options([
                        'gasoline' => __('automotive::vehicles.fuel_types.gasoline'),
                        'diesel' => __('automotive::vehicles.fuel_types.diesel'),
                        'electric' => __('automotive::vehicles.fuel_types.electric'),
                        'hybrid' => __('automotive::vehicles.fuel_types.hybrid'),
                        'lpg' => __('automotive::vehicles.fuel_types.lpg'),
                        'cng' => __('automotive::vehicles.fuel_types.cng'),
                    ])
                    ->searchable()
                    ->native(false)
                    ->columnSpan(1),

                TextInput::make('engine')
                    ->label(__('automotive::vehicles.engine'))
                    ->maxLength(255)
                    ->placeholder(__('automotive::vehicles.engine_placeholder'))
                    ->columnSpan(1),
            ]),

            // Section 3: Additional Information
            Textarea::make('notes')
                ->label(__('automotive::vehicles.notes'))
                ->rows(4)
                ->columnSpanFull()
                ->placeholder(__('automotive::vehicles.notes_placeholder')),

            Toggle::make('is_active')
                ->label(__('automotive::vehicles.is_active'))
                ->default(true)
                ->helperText(__('automotive::vehicles.is_active_help'))
                ->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('license_plate')
                    ->label(__('automotive::vehicles.license_plate'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('car_info')
                    ->label(__('automotive::vehicles.car_info'))
                    ->getStateUsing(function ($record): string {
                        if (! $record->carModel) {
                            return __('automotive::vehicles.not_specified');
                        }
                        $brand = $record->carModel->carBrand->name ?? '?';
                        $model = $record->carModel->name ?? '?';

                        return "{$brand} {$model}";
                    })
                    ->searchable(['car_models.name', 'car_brands.name']),

                TextColumn::make('year')
                    ->label(__('automotive::vehicles.year'))
                    ->sortable()
                    ->alignCenter()
                    ->placeholder(__('automotive::vehicles.not_specified')),

                TextColumn::make('is_active')
                    ->label(__('automotive::vehicles.status'))
                    ->formatStateUsing(fn (bool $state): string => $state
                        ? __('automotive::vehicles.active')
                        : __('automotive::vehicles.inactive'))
                    ->badge()
                    ->color(fn (bool $state): string => $state ? 'success' : 'gray')
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('license_plate');
    }
}
