<?php

namespace Packages\Automotive\Garage\Filament\Resources\DiagnosisResource\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Packages\Automotive\Garage\Enums\DiagnosisStatus;
use Packages\Automotive\Garage\Filament\Resources\VehicleResource\Schemas\VehicleForm;
use Packages\Automotive\Garage\Models\Vehicle;
use Packages\Core\Contacts\Filament\Resources\Contacts\Schemas\ContactForm;

class DiagnosisForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            // Section 1: Vehicle & Customer Information
            Section::make(__('automotive::services.diagnosis.vehicle_customer_info'))
                ->description(__('automotive::services.diagnosis.vehicle_customer_info_desc'))
                ->schema([
                    Grid::make(2)->schema([
                        Select::make('vehicle_id')
                            ->label(__('automotive::services.vehicle'))
                            ->relationship('vehicle', 'license_plate')
                            ->getOptionLabelFromRecordUsing(function ($record) {
                                return $record->license_plate.
                                    ($record->carModel?->carBrand ? ' - '.$record->carModel->carBrand->name : '').
                                    ($record->carModel ? ' '.$record->carModel->name : '');
                            })
                            ->searchable(['license_plate', 'vin'])
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (Set $set, ?int $state) {
                                if ($state) {
                                    $vehicle = Vehicle::with('customer')->find($state);
                                    if ($vehicle && $vehicle->customer_id) {
                                        $set('customer_id', $vehicle->customer_id);
                                    }
                                }
                            })
                            ->manageOptionForm(fn (Schema $schema) => VehicleForm::configure($schema))
                            ->columnSpan(1),

                    ]),

                    Grid::make(2)->schema([
                        DatePicker::make('acceptance_date')
                            ->label(__('automotive::services.diagnosis.acceptance_date'))
                            ->required()
                            ->default(now())
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->columnSpan(1),

                        TextInput::make('mileage_at_acceptance')
                            ->label(__('automotive::services.diagnosis.mileage_at_acceptance'))
                            ->numeric()
                            ->minValue(0)
                            ->suffix('km')
                            ->placeholder('50000')
                            ->columnSpan(1),
                    ]),
                ]),

            // Section 2: Diagnosis Information
            Section::make(__('automotive::services.diagnosis.diagnosis_info'))
                ->schema([
                    Textarea::make('customer_complaint')
                        ->label(__('automotive::services.diagnosis.customer_complaint'))
                        ->placeholder(__('automotive::services.diagnosis.customer_complaint_placeholder'))
                        ->rows(4)
                        ->columnSpanFull(),

                    Textarea::make('initial_diagnosis')
                        ->label(__('automotive::services.diagnosis.initial_diagnosis'))
                        ->placeholder(__('automotive::services.diagnosis.initial_diagnosis_placeholder'))
                        ->rows(4)
                        ->columnSpanFull(),

                    Grid::make(2)->schema([
                        Select::make('status')
                            ->label(__('automotive::services.diagnosis.status'))
                            ->options(DiagnosisStatus::class)
                            ->default(DiagnosisStatus::Draft)
                            ->required()
                            ->native(false)
                            ->columnSpan(1),

                        // Spacer for alignment
                        Hidden::make('_spacer')->columnSpan(1),
                    ]),

                    Textarea::make('notes')
                        ->label(__('automotive::services.diagnosis.notes'))
                        ->placeholder(__('automotive::services.diagnosis.notes_placeholder'))
                        ->rows(3)
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
