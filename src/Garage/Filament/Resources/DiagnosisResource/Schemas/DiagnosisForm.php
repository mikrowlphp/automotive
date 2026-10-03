<?php

namespace Packages\Automotive\Garage\Filament\Resources\DiagnosisResource\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Html;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Packages\Automotive\Garage\Enums\DiagnosisStatus;
use Packages\Automotive\Garage\Filament\Resources\VehicleResource\Schemas\VehicleForm;
use Filament\Support\Icons\Heroicon;

class DiagnosisForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->schema([
                // IMPORTANT INFO ZONE - Vehicle & key dates (no name field for Diagnosis)
                Grid::make(12)->schema([
                    Select::make('vehicle_id')
                        ->hiddenLabel()
                        ->placeholder(__('automotive::services.vehicle'))
                        ->relationship('vehicle', 'license_plate')
                        ->getOptionLabelFromRecordUsing(function ($record) {
                            return $record->license_plate.
                                ($record->carModel?->carBrand ? ' - '.$record->carModel->carBrand->name : '').
                                ($record->carModel ? ' '.$record->carModel->name : '');
                        })
                        ->searchable(['license_plate', 'vin'])
                        ->preload()
                        ->required()
                        ->manageOptionForm(fn (Schema $schema) => VehicleForm::configure($schema))
                        ->suffixIcon(Heroicon::Truck)
                        ->columnSpan(['default' => 12, 'xl' => 6]),

                    DatePicker::make('acceptance_date')
                        ->hiddenLabel()
                        ->placeholder(__('automotive::services.diagnosis.acceptance_date'))
                        ->required()
                        ->default(now())
                        ->native(false)
                        ->displayFormat('d/m/Y')
                        ->suffixIcon(Heroicon::Calendar)
                        ->columnSpan(['default' => 12, 'xl' => 3]),

                    TextInput::make('mileage_at_acceptance')
                        ->hiddenLabel()
                        ->placeholder(__('automotive::services.diagnosis.mileage_at_acceptance'))
                        ->numeric()
                        ->minValue(0)
                        ->suffix('km')
                        ->suffixIcon(Heroicon::ChartBar)
                        ->columnSpan(['default' => 12, 'xl' => 3]),
                ])->columnSpanFull(),

                // SEPARATOR
                Html::make("<hr class='my-6 text-gray-300 w-full' />")->columnSpanFull(),

                // BODY ZONE
                Section::make()
                    ->schema([
                        Group::make([
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

                            // Status is managed by DiagnosisToolbar
                            Hidden::make('status')
                                ->default(DiagnosisStatus::Draft->value),
                        ])->inlineLabel()->columns(12)->columnSpanFull(),
                    ])
                    ->contained(false)
                    ->columns(12)
                    ->columnSpanFull(),

                // NOTES ZONE - Always last, fullspan
                Textarea::make('notes')
                    ->label(__('automotive::services.diagnosis.notes'))
                    ->placeholder(__('automotive::services.diagnosis.notes_placeholder'))
                    ->rows(3)
                    ->columnSpanFull(),
            ])->columns(12)->columnSpanFull(),
        ]);
    }
}
