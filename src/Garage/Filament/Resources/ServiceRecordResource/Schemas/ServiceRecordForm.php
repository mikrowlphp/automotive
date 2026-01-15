<?php

namespace Packages\Automotive\Garage\Filament\Resources\ServiceRecordResource\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Html;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Packages\Automotive\Garage\Enums\ServiceRecordStatus;
use Packages\Automotive\Garage\Filament\Resources\VehicleResource\Schemas\VehicleForm;
use Packages\Automotive\Garage\Models\Vehicle;
use Packages\Core\Contacts\Filament\Resources\Contacts\Schemas\ContactForm;
use Filament\Support\Icons\Heroicon;

class ServiceRecordForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->schema([
                // IMPORTANT INFO ZONE - Vehicle, date & mileage (no name field for ServiceRecord)
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

                // SEPARATOR
                Html::make("<hr class='my-6 text-gray-300 w-full' />")->columnSpanFull(),

                // BODY ZONE - 7/5 column split
                Section::make()
                    ->schema([
                        Group::make([
                            // Left column - Main fields
                            Select::make('customer_id')
                                ->label(__('automotive::services.customer'))
                                ->relationship('customer', 'name')
                                ->required()
                                ->disabled() // Auto-filled from vehicle
                                ->dehydrated()
                                ->manageOptionForm(fn (Schema $schema) => ContactForm::configure($schema)),

                            Textarea::make('customer_complaint')
                                ->label(__('automotive::services.customer_complaint'))
                                ->rows(3)
                                ->placeholder(__('automotive::services.customer_complaint_placeholder')),

                            Textarea::make('diagnosis')
                                ->label(__('automotive::services.diagnosis'))
                                ->rows(3)
                                ->placeholder(__('automotive::services.diagnosis_placeholder')),
                        ])->inlineLabel()->columns(12)->columnSpan([
                            'default' => 12,
                            'xl' => 7,
                        ]),

                        Group::make([
                            // Right column - Status & Total
                            Select::make('status')
                                ->label(__('automotive::services.status'))
                                ->enum(ServiceRecordStatus::class)
                                ->default(ServiceRecordStatus::Draft)
                                ->required()
                                ->native(false),

                            TextInput::make('total_amount')
                                ->label(__('automotive::services.total_amount'))
                                ->numeric()
                                ->prefix('€')
                                ->disabled()
                                ->dehydrated()
                                ->default(0)
                                ->helperText(__('automotive::services.total_amount_help')),
                        ])->inlineLabel()->columns(12)->columnSpan([
                            'default' => 12,
                            'xl' => 5,
                        ]),
                    ])
                    ->contained(false)
                    ->columns(12)
                    ->columnSpanFull(),

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
