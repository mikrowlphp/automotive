<?php

namespace Packages\Automotive\Garage\Filament\Resources;

use App\Library\Extensions\Resource;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Packages\Automotive\Garage\Enums\ServiceType;
use Packages\Automotive\Garage\Filament\Resources\ElectricianServiceResource\Pages;
use Packages\Automotive\Garage\Filament\Resources\ServiceRecordResource\Schemas\ServiceLinesSection;
use Packages\Automotive\Garage\Filament\Resources\ServiceRecordResource\Schemas\ServiceRecordForm;
use Packages\Automotive\Garage\Models\ServiceRecord;

use function App\settings;

class ElectricianServiceResource extends Resource
{
    protected static ?string $model = ServiceRecord::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-bolt';

    protected static ?int $navigationSort = 13;

    protected static ?string $recordTitleAttribute = 'service_date';

    public static function getModelLabel(): string
    {
        return __('automotive::services.types.electrician');
    }

    public static function getPluralModelLabel(): string
    {
        return __('automotive::services.types.electrician_plural');
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

        return settings('enable_electrician', 'services', true);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('type', ServiceType::Electrician)
            ->with(['vehicle', 'customer'])
            ->orderBy('service_date', 'desc');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            // Section 1: vehicle, date, mileage and customer, shared with the generic form
            Section::make([
                ...ServiceRecordForm::header(),
                ServiceRecordForm::customerBody(),
            ])->columns(12)->columnSpanFull(),

            // Section 2: Electrician-specific parameters
            Section::make(__('automotive::services.electrician.parameters'))
                ->description(__('automotive::services.electrician.parameters_desc'))
                ->schema([
                    Grid::make(2)->schema([
                        Select::make('parameters.system_area')
                            ->label(__('automotive::services.electrician.system_area'))
                            ->options([
                                'engine_management' => __('automotive::services.electrician.areas.engine_management'),
                                'starting_system' => __('automotive::services.electrician.areas.starting_system'),
                                'charging_system' => __('automotive::services.electrician.areas.charging_system'),
                                'lighting' => __('automotive::services.electrician.areas.lighting'),
                                'sensors' => __('automotive::services.electrician.areas.sensors'),
                                'infotainment' => __('automotive::services.electrician.areas.infotainment'),
                                'climate_control' => __('automotive::services.electrician.areas.climate_control'),
                                'safety_systems' => __('automotive::services.electrician.areas.safety_systems'),
                                'wiring' => __('automotive::services.electrician.areas.wiring'),
                                'other' => __('automotive::services.electrician.areas.other'),
                            ])
                            ->required()
                            ->native(false)
                            ->columnSpan(1),

                        Select::make('parameters.service_type')
                            ->label(__('automotive::services.electrician.service_type'))
                            ->options([
                                'diagnosis' => __('automotive::services.electrician.service_types.diagnosis'),
                                'repair' => __('automotive::services.electrician.service_types.repair'),
                                'replacement' => __('automotive::services.electrician.service_types.replacement'),
                                'installation' => __('automotive::services.electrician.service_types.installation'),
                                'programming' => __('automotive::services.electrician.service_types.programming'),
                            ])
                            ->required()
                            ->native(false)
                            ->columnSpan(1),
                    ]),

                    Textarea::make('parameters.diagnostic_codes')
                        ->label(__('automotive::services.electrician.diagnostic_codes'))
                        ->placeholder(__('automotive::services.electrician.diagnostic_codes_placeholder'))
                        ->helperText(__('automotive::services.electrician.diagnostic_codes_help'))
                        ->rows(2)
                        ->columnSpanFull(),

                    CheckboxList::make('parameters.components_tested')
                        ->label(__('automotive::services.electrician.components_tested'))
                        ->options([
                            'battery' => __('automotive::services.electrician.components.battery'),
                            'alternator' => __('automotive::services.electrician.components.alternator'),
                            'starter' => __('automotive::services.electrician.components.starter'),
                            'fuses' => __('automotive::services.electrician.components.fuses'),
                            'relays' => __('automotive::services.electrician.components.relays'),
                            'wiring_harness' => __('automotive::services.electrician.components.wiring_harness'),
                            'ecu' => __('automotive::services.electrician.components.ecu'),
                            'sensors' => __('automotive::services.electrician.components.sensors'),
                            'actuators' => __('automotive::services.electrician.components.actuators'),
                        ])
                        ->columns(3)
                        ->columnSpanFull(),

                    // Battery status section
                    Fieldset::make(__('automotive::services.electrician.battery_status'))
                        ->schema([
                            TextInput::make('parameters.battery_voltage')
                                ->label(__('automotive::services.electrician.battery_voltage'))
                                ->numeric()
                                ->minValue(0)
                                ->maxValue(20)
                                ->step(0.1)
                                ->suffix('V'),

                            TextInput::make('parameters.battery_cca')
                                ->label(__('automotive::services.electrician.battery_cca'))
                                ->numeric()
                                ->minValue(0)
                                ->suffix('A')
                                ->helperText(__('automotive::services.electrician.battery_cca_help')),

                            TextInput::make('parameters.battery_health')
                                ->label(__('automotive::services.electrician.battery_health'))
                                ->numeric()
                                ->minValue(0)
                                ->maxValue(100)
                                ->suffix('%'),

                            Select::make('parameters.battery_condition')
                                ->label(__('automotive::services.electrician.battery_condition'))
                                ->options([
                                    'good' => __('automotive::services.electrician.conditions.good'),
                                    'fair' => __('automotive::services.electrician.conditions.fair'),
                                    'weak' => __('automotive::services.electrician.conditions.weak'),
                                    'replace' => __('automotive::services.electrician.conditions.replace'),
                                ])
                                ->native(false),
                        ])
                        ->columns(4),

                    Toggle::make('parameters.firmware_update_required')
                        ->label(__('automotive::services.electrician.firmware_update_required'))
                        ->helperText(__('automotive::services.electrician.firmware_update_help')),

                    Textarea::make('parameters.work_performed')
                        ->label(__('automotive::services.electrician.work_performed'))
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('notes')
                        ->label(__('automotive::services.notes'))
                        ->rows(2)
                        ->columnSpanFull(),
                ]),

            // Section 3: Priced lines, whose sum is the total amount
            ServiceLinesSection::make(),
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

                TextColumn::make('parameters.system_area')
                    ->label(__('automotive::services.electrician.system_area'))
                    ->formatStateUsing(fn ($state) => $state ? __("automotive::services.electrician.areas.{$state}") : '-'),

                TextColumn::make('parameters.service_type')
                    ->label(__('automotive::services.electrician.service_type'))
                    ->formatStateUsing(fn ($state) => $state ? __("automotive::services.electrician.service_types.{$state}") : '-'),

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
            'index' => Pages\ListElectricianServices::route('/'),
            'create' => Pages\CreateElectricianService::route('/create'),
            'edit' => Pages\EditElectricianService::route('/{record}/edit'),
        ];
    }

    public static function mutateFormDataBeforeCreate(array $data): array
    {
        $data['type'] = ServiceType::Electrician;

        return $data;
    }
}
