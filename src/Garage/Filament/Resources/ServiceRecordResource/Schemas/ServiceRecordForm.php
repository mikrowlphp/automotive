<?php

namespace Packages\Automotive\Garage\Filament\Resources\ServiceRecordResource\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Packages\Automotive\Garage\Enums\ServiceRecordStatus;
use Packages\Automotive\Garage\Filament\Resources\VehicleResource\Schemas\VehicleForm;
use Packages\Automotive\Garage\Models\Vehicle;
use Packages\Core\Contacts\Filament\Resources\Contacts\Schemas\ContactForm;

class ServiceRecordForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            // Section 1: Service Information
            Section::make(__('automotive::services.service_information'))
                ->description(__('automotive::services.service_information_desc'))
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
                                    // Auto-fill customer from vehicle
                                    $set('customer_id', $vehicle->customer_id);
                                    // Auto-fill current mileage
                                    $set('mileage_at_service', $vehicle->mileage);
                                }
                            })
                            ->manageOptionForm(fn (Schema $schema) => VehicleForm::configure($schema))
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
                            ->disabled() // Auto-filled from vehicle
                            ->dehydrated()
                            ->manageOptionForm(fn (Schema $schema) => ContactForm::configure($schema))
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

            // Section 2: Service Details
            Section::make(__('automotive::services.service_details'))
                ->schema([
                    Textarea::make('customer_complaint')
                        ->label(__('automotive::services.customer_complaint'))
                        ->rows(3)
                        ->columnSpanFull()
                        ->placeholder(__('automotive::services.customer_complaint_placeholder')),

                    Textarea::make('diagnosis')
                        ->label(__('automotive::services.diagnosis'))
                        ->rows(3)
                        ->columnSpanFull()
                        ->placeholder(__('automotive::services.diagnosis_placeholder')),

                    Textarea::make('notes')
                        ->label(__('automotive::services.notes'))
                        ->rows(3)
                        ->columnSpanFull()
                        ->placeholder(__('automotive::services.notes_placeholder')),

                    TextInput::make('total_amount')
                        ->label(__('automotive::services.total_amount'))
                        ->numeric()
                        ->prefix('€')
                        ->disabled()
                        ->dehydrated()
                        ->default(0)
                        ->helperText(__('automotive::services.total_amount_help'))
                        ->columnSpan(1),
                ]),
        ]);
    }
}
