<?php

namespace Packages\Automotive\Garage\Filament\Resources;

use App\Library\Extensions\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Packages\Automotive\Garage\Enums\ServiceType;
use Packages\Automotive\Garage\Filament\Resources\MechanicsServiceResource\Pages;
use Packages\Automotive\Garage\Filament\Resources\ServiceRecordResource\Schemas\ServiceLinesSection;
use Packages\Automotive\Garage\Filament\Resources\ServiceRecordResource\Schemas\ServiceRecordForm;
use Packages\Automotive\Garage\Models\ServiceRecord;

use function App\settings;

class MechanicsServiceResource extends Resource
{
    protected static ?string $model = ServiceRecord::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?int $navigationSort = 10;

    protected static ?string $recordTitleAttribute = 'service_date';

    public static function getModelLabel(): string
    {
        return __('automotive::services.types.mechanics');
    }

    public static function getPluralModelLabel(): string
    {
        return __('automotive::services.types.mechanics_plural');
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

        return settings('enable_mechanics', 'services', true);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('type', ServiceType::Mechanics)
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

            // Section 2: Mechanics-specific parameters
            Section::make(__('automotive::services.mechanics.parameters'))
                ->description(__('automotive::services.mechanics.parameters_desc'))
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('parameters.labor_hours')
                            ->label(__('automotive::services.mechanics.labor_hours'))
                            ->numeric()
                            ->minValue(0)
                            ->step(0.5)
                            ->suffix(__('automotive::services.hours'))
                            ->columnSpan(1),

                        Select::make('parameters.work_type')
                            ->label(__('automotive::services.mechanics.work_type'))
                            ->options([
                                'maintenance' => __('automotive::services.mechanics.work_types.maintenance'),
                                'repair' => __('automotive::services.mechanics.work_types.repair'),
                                'inspection' => __('automotive::services.mechanics.work_types.inspection'),
                                'overhaul' => __('automotive::services.mechanics.work_types.overhaul'),
                            ])
                            ->native(false)
                            ->columnSpan(1),
                    ]),

                    Textarea::make('parameters.diagnosis')
                        ->label(__('automotive::services.mechanics.diagnosis'))
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('parameters.work_performed')
                        ->label(__('automotive::services.mechanics.work_performed'))
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

                TextColumn::make('parameters.work_type')
                    ->label(__('automotive::services.mechanics.work_type'))
                    ->formatStateUsing(fn ($state) => $state ? __("automotive::services.mechanics.work_types.{$state}") : '-'),

                TextColumn::make('parameters.labor_hours')
                    ->label(__('automotive::services.mechanics.labor_hours'))
                    ->suffix(' '.__('automotive::services.hours')),

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
            'index' => Pages\ListMechanicsServices::route('/'),
            'create' => Pages\CreateMechanicsService::route('/create'),
            'edit' => Pages\EditMechanicsService::route('/{record}/edit'),
        ];
    }

    public static function mutateFormDataBeforeCreate(array $data): array
    {
        $data['type'] = ServiceType::Mechanics;

        return $data;
    }
}
