<?php

namespace Packages\Automotive\Garage\Filament\Resources;

use App\Library\Extensions\Resource;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Packages\Automotive\Garage\Enums\ServiceRecordStatus;
use Packages\Automotive\Garage\Enums\ServiceType;
use Packages\Automotive\Garage\Filament\Resources\TireServiceResource\Pages;
use Packages\Automotive\Garage\Models\ServiceRecord;
use Packages\Automotive\Garage\Models\Vehicle;
use Packages\Sales\Shared\Models\Product;
use Packages\Sales\Shared\Models\ProductCategory;

use function App\settings;

class TireServiceResource extends Resource
{
    protected static ?string $model = ServiceRecord::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-circle-stack';

    protected static ?int $navigationSort = 12;

    protected static ?string $recordTitleAttribute = 'service_date';

    public static function getModelLabel(): string
    {
        return __('automotive::services.types.tires');
    }

    public static function getPluralModelLabel(): string
    {
        return __('automotive::services.types.tires_plural');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('automotive::services.navigation_group');
    }

    public static function shouldRegisterNavigation(): bool
    {
        if (! tenant()) {
            return true; // Default to visible when tenant not initialized
        }

        return settings('enable_tires', 'services', true);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('type', ServiceType::Tires)
            ->with(['vehicle', 'customer'])
            ->orderBy('service_date', 'desc');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            // Section 1: Service Information (common)
            Section::make(__('automotive::services.service_information'))
                ->schema([
                    Grid::make(3)->schema([
                        Select::make('vehicle_id')
                            ->label(__('automotive::services.vehicle'))
                            ->relationship('vehicle', 'license_plate')
                            ->getOptionLabelFromRecordUsing(function ($record) {
                                $plate = $record->license_plate;
                                $brand = $record->carModel?->carBrand?->name ?? '?';
                                $model = $record->carModel?->name ?? '?';

                                return "{$plate} - {$brand} {$model}";
                            })
                            ->searchable(['license_plate'])
                            ->required()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function (?string $state, Set $set) {
                                if (! $state) {
                                    return;
                                }
                                $vehicle = Vehicle::find($state);
                                if ($vehicle) {
                                    $set('customer_id', $vehicle->customer_id);
                                    $set('mileage_at_service', $vehicle->mileage);
                                    // Detect if motorcycle (2 wheels) or car (4 wheels)
                                    $bodyType = $vehicle->carModel?->body_type ?? null;
                                    $isTwoWheeler = in_array($bodyType, ['motorcycle', 'scooter', 'moped']);
                                    $set('parameters.is_two_wheeler', $isTwoWheeler);
                                }
                            })
                            ->columnSpan(2),

                        DatePicker::make('service_date')
                            ->label(__('automotive::services.service_date'))
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->default(now())
                            ->columnSpan(1),
                    ]),

                    Grid::make(3)->schema([
                        Select::make('customer_id')
                            ->label(__('automotive::services.customer'))
                            ->relationship('customer', 'name')
                            ->required()
                            ->disabled()
                            ->dehydrated()
                            ->columnSpan(1),

                        TextInput::make('mileage_at_service')
                            ->label(__('automotive::services.mileage_at_service'))
                            ->numeric()
                            ->minValue(0)
                            ->suffix('km')
                            ->columnSpan(1),

                        Select::make('status')
                            ->label(__('automotive::services.status'))
                            ->enum(ServiceRecordStatus::class)
                            ->default(ServiceRecordStatus::Draft)
                            ->required()
                            ->native(false)
                            ->columnSpan(1),
                    ]),
                ]),

            // Section 2: Tire-specific parameters
            Section::make(__('automotive::services.tires.parameters'))
                ->description(__('automotive::services.tires.parameters_desc'))
                ->schema([
                    Toggle::make('parameters.is_two_wheeler')
                        ->label(__('automotive::services.tires.is_two_wheeler'))
                        ->helperText(__('automotive::services.tires.is_two_wheeler_help'))
                        ->live()
                        ->columnSpanFull(),

                    Grid::make(2)->schema([
                        Select::make('parameters.service_type')
                            ->label(__('automotive::services.tires.service_type'))
                            ->options([
                                'replacement' => __('automotive::services.tires.service_types.replacement'),
                                'rotation' => __('automotive::services.tires.service_types.rotation'),
                                'balancing' => __('automotive::services.tires.service_types.balancing'),
                                'alignment' => __('automotive::services.tires.service_types.alignment'),
                                'repair' => __('automotive::services.tires.service_types.repair'),
                                'seasonal_change' => __('automotive::services.tires.service_types.seasonal_change'),
                            ])
                            ->required()
                            ->native(false)
                            ->columnSpan(1),

                        Select::make('parameters.tire_season')
                            ->label(__('automotive::services.tires.tire_season'))
                            ->options([
                                'summer' => __('automotive::services.tires.seasons.summer'),
                                'winter' => __('automotive::services.tires.seasons.winter'),
                                'all_season' => __('automotive::services.tires.seasons.all_season'),
                            ])
                            ->native(false)
                            ->columnSpan(1),
                    ]),

                    // === 4-WHEEL VEHICLE TIRE GRID ===
                    Grid::make(2)
                        ->schema([
                            // Front Left
                            Fieldset::make(__('automotive::services.tires.positions.front_left'))
                                ->schema(static::getTireFieldsSchema('parameters.front_left'))
                                ->columns(2),

                            // Front Right
                            Fieldset::make(__('automotive::services.tires.positions.front_right'))
                                ->schema(static::getTireFieldsSchema('parameters.front_right'))
                                ->columns(2),

                            // Rear Left
                            Fieldset::make(__('automotive::services.tires.positions.rear_left'))
                                ->schema(static::getTireFieldsSchema('parameters.rear_left'))
                                ->columns(2),

                            // Rear Right
                            Fieldset::make(__('automotive::services.tires.positions.rear_right'))
                                ->schema(static::getTireFieldsSchema('parameters.rear_right'))
                                ->columns(2),
                        ])
                        ->visible(fn (Get $get) => ! $get('parameters.is_two_wheeler'))
                        ->columnSpanFull(),

                    // === 2-WHEEL VEHICLE TIRE GRID ===
                    Grid::make(1)
                        ->schema([
                            // Front
                            Fieldset::make(__('automotive::services.tires.positions.front'))
                                ->schema(static::getTireFieldsSchema('parameters.front'))
                                ->columns(4),

                            // Rear
                            Fieldset::make(__('automotive::services.tires.positions.rear'))
                                ->schema(static::getTireFieldsSchema('parameters.rear'))
                                ->columns(4),
                        ])
                        ->visible(fn (Get $get) => $get('parameters.is_two_wheeler'))
                        ->columnSpanFull(),

                    Grid::make(2)->schema([
                        Toggle::make('parameters.store_old_tires')
                            ->label(__('automotive::services.tires.store_old_tires'))
                            ->helperText(__('automotive::services.tires.store_old_tires_help')),

                        TextInput::make('parameters.storage_location')
                            ->label(__('automotive::services.tires.storage_location'))
                            ->placeholder(__('automotive::services.tires.storage_location_placeholder')),
                    ]),

                    Textarea::make('notes')
                        ->label(__('automotive::services.notes'))
                        ->rows(2)
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('service_date')
                    ->label(__('automotive::services.service_date'))
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('vehicle.license_plate')
                    ->label(__('automotive::services.vehicle'))
                    ->searchable(),

                TextColumn::make('customer.name')
                    ->label(__('automotive::services.customer'))
                    ->searchable(),

                TextColumn::make('parameters.service_type')
                    ->label(__('automotive::services.tires.service_type'))
                    ->formatStateUsing(fn ($state) => $state ? __("automotive::services.tires.service_types.{$state}") : '-'),

                TextColumn::make('parameters.tire_season')
                    ->label(__('automotive::services.tires.tire_season'))
                    ->formatStateUsing(fn ($state) => $state ? __("automotive::services.tires.seasons.{$state}") : '-')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'summer' => 'warning',
                        'winter' => 'info',
                        'all_season' => 'success',
                        default => 'gray',
                    }),

                TextColumn::make('status')
                    ->label(__('automotive::services.status'))
                    ->badge(),

                TextColumn::make('total_amount')
                    ->label(__('automotive::services.total_amount'))
                    ->money('EUR')
                    ->sortable(),
            ])
            ->defaultSort('service_date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTireServices::route('/'),
            'create' => Pages\CreateTireService::route('/create'),
            'edit' => Pages\EditTireService::route('/{record}/edit'),
        ];
    }

    public static function mutateFormDataBeforeCreate(array $data): array
    {
        $data['type'] = ServiceType::Tires;

        return $data;
    }

    /**
     * Get the tire fields schema for a specific position.
     * Used to avoid duplicating the same fields for each tire position.
     */
    protected static function getTireFieldsSchema(string $prefix): array
    {
        return [
            // Product selector - searches by brand name or product name (filtered by "pneumatici" category)
            Select::make("{$prefix}.product_id")
                ->label(__('automotive::services.tires.tire_product'))
                ->options(function () {
                    $tiresCategory = ProductCategory::where('slug', 'pneumatici')->first();

                    return Product::query()
                        ->with('brand')
                        ->when($tiresCategory, fn ($q) => $q->where('category_id', $tiresCategory->id))
                        ->get()
                        ->mapWithKeys(fn ($product) => [
                            $product->id => ($product->brand?->name ? $product->brand->name.' - ' : '').$product->name,
                        ]);
                })
                ->searchable()
                ->placeholder(__('automotive::services.tires.search_tire'))
                ->columnSpanFull(),

            TextInput::make("{$prefix}.size")
                ->label(__('automotive::services.tires.size'))
                ->placeholder('225/45R17'),

            TextInput::make("{$prefix}.tread_depth")
                ->label(__('automotive::services.tires.tread_depth'))
                ->numeric()
                ->minValue(0)
                ->maxValue(12)
                ->suffix('mm'),

            TextInput::make("{$prefix}.dot")
                ->label(__('automotive::services.tires.dot'))
                ->placeholder('2024'),

            TextInput::make("{$prefix}.load_speed")
                ->label(__('automotive::services.tires.load_speed'))
                ->placeholder('91W'),
        ];
    }
}
