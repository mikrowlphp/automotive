<?php

namespace Packages\Automotive\Garage\Filament\Resources;

use App\Library\Extensions\Resource;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Packages\Automotive\Garage\Enums\ServiceRecordStatus;
use Packages\Automotive\Garage\Enums\ServiceType;
use Packages\Automotive\Garage\Filament\Resources\BodyworkServiceResource\Pages;
use Packages\Automotive\Garage\Models\ServiceRecord;
use Packages\Automotive\Garage\Models\Vehicle;
use Packages\Sales\Shared\Models\Product;
use Packages\Sales\Shared\Models\ProductCategory;

use function App\settings;

class BodyworkServiceResource extends Resource
{
    protected static ?string $model = ServiceRecord::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-truck';

    protected static ?int $navigationSort = 11;

    protected static ?string $recordTitleAttribute = 'service_date';

    public static function getModelLabel(): string
    {
        return __('automotive::services.types.bodywork');
    }

    public static function getPluralModelLabel(): string
    {
        return __('automotive::services.types.bodywork_plural');
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

        return settings('enable_bodywork', 'services', true);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('type', ServiceType::Bodywork)
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

            // Section 2: Bodywork-specific parameters
            Section::make(__('automotive::services.bodywork.parameters'))
                ->description(__('automotive::services.bodywork.parameters_desc'))
                ->schema([
                    CheckboxList::make('parameters.damage_areas')
                        ->label(__('automotive::services.bodywork.damage_areas'))
                        ->options([
                            'front_bumper' => __('automotive::services.bodywork.areas.front_bumper'),
                            'rear_bumper' => __('automotive::services.bodywork.areas.rear_bumper'),
                            'hood' => __('automotive::services.bodywork.areas.hood'),
                            'trunk' => __('automotive::services.bodywork.areas.trunk'),
                            'roof' => __('automotive::services.bodywork.areas.roof'),
                            'left_front_door' => __('automotive::services.bodywork.areas.left_front_door'),
                            'left_rear_door' => __('automotive::services.bodywork.areas.left_rear_door'),
                            'right_front_door' => __('automotive::services.bodywork.areas.right_front_door'),
                            'right_rear_door' => __('automotive::services.bodywork.areas.right_rear_door'),
                            'left_fender' => __('automotive::services.bodywork.areas.left_fender'),
                            'right_fender' => __('automotive::services.bodywork.areas.right_fender'),
                            'left_quarter_panel' => __('automotive::services.bodywork.areas.left_quarter_panel'),
                            'right_quarter_panel' => __('automotive::services.bodywork.areas.right_quarter_panel'),
                        ])
                        ->columns(3)
                        ->columnSpanFull(),

                    Grid::make(3)->schema([
                        Select::make('parameters.repair_type')
                            ->label(__('automotive::services.bodywork.repair_type'))
                            ->options([
                                'dent_repair' => __('automotive::services.bodywork.repair_types.dent_repair'),
                                'scratch_repair' => __('automotive::services.bodywork.repair_types.scratch_repair'),
                                'partial_repaint' => __('automotive::services.bodywork.repair_types.partial_repaint'),
                                'full_repaint' => __('automotive::services.bodywork.repair_types.full_repaint'),
                                'panel_replacement' => __('automotive::services.bodywork.repair_types.panel_replacement'),
                            ])
                            ->native(false)
                            ->columnSpan(1),

                        Select::make('parameters.paint_type')
                            ->label(__('automotive::services.bodywork.paint_type'))
                            ->options([
                                'solid' => __('automotive::services.bodywork.paint_types.solid'),
                                'metallic' => __('automotive::services.bodywork.paint_types.metallic'),
                                'pearl' => __('automotive::services.bodywork.paint_types.pearl'),
                                'matte' => __('automotive::services.bodywork.paint_types.matte'),
                            ])
                            ->native(false)
                            ->columnSpan(1),

                        TextInput::make('parameters.paint_code')
                            ->label(__('automotive::services.bodywork.paint_code'))
                            ->placeholder('es. LY9T')
                            ->columnSpan(1),
                    ]),

                    Grid::make(2)->schema([
                        TextInput::make('parameters.estimated_days')
                            ->label(__('automotive::services.bodywork.estimated_days'))
                            ->numeric()
                            ->minValue(1)
                            ->suffix(__('automotive::services.days'))
                            ->columnSpan(1),

                        TextInput::make('parameters.insurance_claim')
                            ->label(__('automotive::services.bodywork.insurance_claim'))
                            ->placeholder(__('automotive::services.bodywork.insurance_claim_placeholder'))
                            ->columnSpan(1),
                    ]),

                    Textarea::make('parameters.damage_description')
                        ->label(__('automotive::services.bodywork.damage_description'))
                        ->rows(3)
                        ->columnSpanFull(),

                    Repeater::make('parameters.parts_used')
                        ->label(__('automotive::services.bodywork.parts_used'))
                        ->schema([
                            Select::make('product_id')
                                ->label(__('automotive::services.part'))
                                ->options(function () {
                                    $bodyworkCategory = ProductCategory::where('slug', 'carrozzeria')->first();

                                    return Product::query()
                                        ->with('brand')
                                        ->when($bodyworkCategory, fn ($q) => $q->where('category_id', $bodyworkCategory->id))
                                        ->get()
                                        ->mapWithKeys(fn ($product) => [
                                            $product->id => ($product->brand?->name ? $product->brand->name.' - ' : '').$product->name,
                                        ]);
                                })
                                ->searchable()
                                ->placeholder(__('automotive::services.bodywork.search_part'))
                                ->required(),

                            TextInput::make('quantity')
                                ->label(__('automotive::services.quantity'))
                                ->numeric()
                                ->default(1)
                                ->minValue(1)
                                ->required(),

                            TextInput::make('note')
                                ->label(__('automotive::services.note')),
                        ])
                        ->columns(3)
                        ->defaultItems(0)
                        ->addActionLabel(__('automotive::services.add_part'))
                        ->reorderable(false)
                        ->grid(1)
                        ->columnSpanFull(),

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

                TextColumn::make('parameters.repair_type')
                    ->label(__('automotive::services.bodywork.repair_type'))
                    ->formatStateUsing(fn ($state) => $state ? __("automotive::services.bodywork.repair_types.{$state}") : '-'),

                TextColumn::make('parameters.estimated_days')
                    ->label(__('automotive::services.bodywork.estimated_days'))
                    ->suffix(' '.__('automotive::services.days')),

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
            'index' => Pages\ListBodyworkServices::route('/'),
            'create' => Pages\CreateBodyworkService::route('/create'),
            'edit' => Pages\EditBodyworkService::route('/{record}/edit'),
        ];
    }

    public static function mutateFormDataBeforeCreate(array $data): array
    {
        $data['type'] = ServiceType::Bodywork;

        return $data;
    }
}
