<?php

namespace Packages\Automotive\Garage\Filament\Resources\VehicleResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Html;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Packages\Automotive\Garage\Filament\Resources\CarBrandResource\Schemas\CarBrandForm;
use Packages\Automotive\Garage\Filament\Resources\CarModelResource\Schemas\CarModelForm;
use Packages\Core\Shared\Filament\Resources\Contacts\Schemas\ContactForm;

class VehicleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make([
                // Main field: License plate alone
                TextInput::make('license_plate')
                    ->hiddenLabel()
                    ->placeholder(__('automotive::vehicles.license_plate'))
                    ->required()
                    ->string()
                    ->main()
                    ->maxLength(20)
                    ->unique(ignoreRecord: true)
                    ->columnSpan([
                        'default' => 12,
                        'lg' => 8,
                    ]),

                Html::make('<hr class="my-6 text-gray-300 w-full" />')->columnSpanFull(),

                // Vehicle details section
                Section::make()
                    ->schema([
                        Group::make([
                            TextInput::make('vin')
                                ->label(__('automotive::vehicles.vin'))
                                ->inlineLabel()
                                ->maxLength(17)
                                ->columnSpanFull(),

                            Select::make('customer_id')
                                ->label(__('automotive::vehicles.customer'))
                                ->inlineLabel()
                                ->relationship('customer', 'name')
                                ->searchable()
                                ->required()
                                ->preload()
                                ->manageOptionForm(fn (Schema $schema) => ContactForm::configure($schema))
                                ->columnSpanFull(),

                            // Virtual field for car brand selection (cascading select pattern)
                            Select::make('car_brand_id')
                                ->label(__('automotive::vehicles.car_brand'))
                                ->inlineLabel()
                                ->relationship('carModel.carBrand', 'name')
                                ->searchable()
                                ->preload()
                                ->live()
                                ->dehydrated(false)
                                ->afterStateUpdated(function (Set $set) {
                                    $set('car_model_id', null);
                                })
                                ->manageOptionForm(fn (Schema $schema) => CarBrandForm::configure($schema))
                                ->columnSpanFull(),

                            // Actual car_model_id field (filtered by brand)
                            Select::make('car_model_id')
                                ->label(__('automotive::vehicles.car_model'))
                                ->inlineLabel()
                                ->relationship('carModel', 'name', fn ($query, Get $get) => $query
                                    ->where('car_brand_id', $get('car_brand_id'))
                                    ->where('is_active', true))
                                ->searchable()
                                ->required()
                                ->visible(fn (Get $get) => filled($get('car_brand_id')))
                                ->manageOptionForm(fn (Schema $schema) => CarModelForm::configure($schema))
                                ->columnSpanFull(),

                            TextInput::make('color')
                                ->label(__('automotive::vehicles.color'))
                                ->inlineLabel()
                                ->maxLength(255)
                                ->columnSpanFull(),

                            TextInput::make('year')
                                ->label(__('automotive::vehicles.year'))
                                ->inlineLabel()
                                ->numeric()
                                ->minValue(1900)
                                ->maxValue(2100)
                                ->placeholder('2020')
                                ->columnSpanFull(),
                        ])->columnSpan([
                            'default' => 12,
                            'xl' => 7,
                        ])->columns(12),

                        Group::make([
                            TextInput::make('mileage')
                                ->label(__('automotive::vehicles.mileage'))
                                ->inlineLabel()
                                ->numeric()
                                ->minValue(0)
                                ->suffix('km')
                                ->placeholder('50000')
                                ->columnSpanFull(),

                            Select::make('fuel_type')
                                ->label(__('automotive::vehicles.fuel_type'))
                                ->inlineLabel()
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
                                ->columnSpanFull(),

                            TextInput::make('engine')
                                ->label(__('automotive::vehicles.engine'))
                                ->inlineLabel()
                                ->maxLength(255)
                                ->placeholder(__('automotive::vehicles.engine_placeholder'))
                                ->columnSpanFull(),

                            Toggle::make('is_active')
                                ->label(__('automotive::vehicles.is_active'))
                                ->inlineLabel()
                                ->default(true)
                                ->columnSpanFull(),
                        ])->columnSpan([
                            'default' => 12,
                            'xl' => 5,
                        ])->columns(12),
                    ])
                    ->contained(false)
                    ->columns(12)
                    ->columnSpan(12),

                // NOTES ZONE - Always last, fullspan
                Textarea::make('notes')
                    ->label(__('automotive::vehicles.notes'))
                    ->placeholder(__('automotive::vehicles.notes_placeholder'))
                    ->rows(4)
                    ->columnSpanFull(),
            ])->columns(12)->columnSpan(['default' => 12]),
        ]);
    }
}
