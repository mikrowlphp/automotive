<?php

namespace Packages\Automotive\Garage\Filament\Resources\ServiceRecordResource\Schemas;

use Closure;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Html;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Packages\Automotive\Garage\Enums\ServiceRecordStatus;
use Packages\Automotive\Garage\Filament\Resources\VehicleResource\Schemas\VehicleForm;
use Packages\Automotive\Garage\Models\Vehicle;
use Packages\Core\Shared\Filament\Resources\Contacts\Schemas\ContactForm;
use Filament\Support\Icons\Heroicon;

class ServiceRecordForm
{
    /**
     * Vehicle, date and mileage, then the separator. Shared by the generic form and by the forms of each
     * service type, which have no name field: the vehicle is what identifies the record.
     *
     * @param  (Closure(Vehicle, Set): void)|null  $onVehiclePicked  Extra work when a vehicle is picked, for forms
     *                                                               with parameters that depend on it
     * @return array<Component>
     */
    public static function header(?Closure $onVehiclePicked = null): array
    {
        return [
            Grid::make(12)->schema([
                Select::make('vehicle_id')
                    ->hiddenLabel()
                    ->placeholder(__('automotive::services.vehicle'))
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
                    ->afterStateUpdated(function (?string $state, Set $set) use ($onVehiclePicked) {
                        if (! $state) {
                            return;
                        }

                        $vehicle = Vehicle::find($state);
                        if ($vehicle) {
                            // Auto-fill customer from vehicle
                            $set('customer_id', $vehicle->customer_id);
                            // Auto-fill current mileage
                            $set('mileage_at_service', $vehicle->mileage);

                            if ($onVehiclePicked) {
                                $onVehiclePicked($vehicle, $set);
                            }
                        }
                    })
                    ->manageOptionForm(fn (Schema $schema) => VehicleForm::configure($schema))
                    ->suffixIcon(Heroicon::Truck)
                    ->columnSpan(['default' => 12, 'xl' => 4]),

                DatePicker::make('service_date')
                    ->hiddenLabel()
                    ->placeholder(__('automotive::services.service_date'))
                    ->required()
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->default(now())
                    ->suffixIcon(Heroicon::Calendar)
                    ->columnSpan(['default' => 12, 'xl' => 4]),

                TextInput::make('mileage_at_service')
                    ->hiddenLabel()
                    ->placeholder(__('automotive::services.mileage_at_service'))
                    ->numeric()
                    ->minValue(0)
                    ->suffix('km')
                    ->suffixIcon(Heroicon::ChartBar)
                    ->columnSpan(['default' => 12, 'xl' => 4]),
            ])->columnSpanFull(),

            Html::make("<hr class='my-6 text-gray-300 w-full' />")->columnSpanFull(),
        ];
    }

    /**
     * The customer of the vehicle, filled when the vehicle is picked: the field cannot be edited, but it is saved.
     */
    public static function customerSelect(): Select
    {
        return Select::make('customer_id')
            ->label(__('automotive::services.customer'))
            ->relationship('customer', 'name')
            ->required()
            ->disabled() // Auto-filled from vehicle
            ->dehydrated()
            ->manageOptionForm(fn (Schema $schema) => ContactForm::configure($schema));
    }

    /**
     * Body of the forms of each service type: the customer and the hidden status. What is specific to the
     * type follows in its own section.
     */
    public static function customerBody(): Section
    {
        return Section::make()
            ->schema([
                Group::make([
                    static::customerSelect()->columnSpanFull(),

                    // Status is managed by ServiceRecordToolbar
                    Hidden::make('status')
                        ->default(ServiceRecordStatus::Draft->value),
                ])->inlineLabel()->columns(12)->columnSpanFull(),
            ])
            ->contained(false)
            ->columns(12)
            ->columnSpanFull();
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->schema([
                // HEADER and SEPARATOR - Vehicle, date & mileage (no name field for ServiceRecord)
                ...static::header(),

                // BODY ZONE - 7/5 column split
                Section::make()
                    ->schema([
                        Group::make([
                            // Left column - Main fields
                            static::customerSelect()->columnSpanFull(),

                            Textarea::make('customer_complaint')
                                ->label(__('automotive::services.customer_complaint'))
                                ->rows(3)
                                ->placeholder(__('automotive::services.customer_complaint_placeholder'))
                                ->columnSpanFull(),

                            Textarea::make('diagnosis')
                                ->label(__('automotive::services.diagnosis_label'))
                                ->rows(3)
                                ->placeholder(__('automotive::services.diagnosis_placeholder'))
                                ->columnSpanFull(),
                        ])->inlineLabel()->columns(12)->columnSpan([
                            'default' => 12,
                            'xl' => 7,
                        ]),

                        Group::make([
                            // Right column - Status & Total
                            // Status is managed by ServiceRecordToolbar
                            Hidden::make('status')
                                ->default(ServiceRecordStatus::Draft->value),

                            ServiceLinesSection::totalField()->columnSpanFull(),
                        ])->inlineLabel()->columns(12)->columnSpan([
                            'default' => 12,
                            'xl' => 5,
                        ]),
                    ])
                    ->contained(false)
                    ->columns(12)
                    ->columnSpanFull(),

                // LINES ZONE - The total above is their sum
                ServiceLinesSection::make(withTotal: false),

                // NOTES ZONE - Always last, fullspan
                Textarea::make('notes')
                    ->label(__('automotive::services.notes'))
                    ->rows(3)
                    ->columnSpanFull()
                    ->placeholder(__('automotive::services.notes_placeholder')),
            ])->columns(12)->columnSpanFull(),
        ]);
    }
}
