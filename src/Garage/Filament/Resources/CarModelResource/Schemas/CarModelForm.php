<?php

namespace Packages\Automotive\Garage\Filament\Resources\CarModelResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Packages\Automotive\Garage\Filament\Resources\CarBrandResource\Schemas\CarBrandForm;

class CarModelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            // Section 1: Model Information
            Section::make(__('automotive::vehicles.model_information'))
                ->description(__('automotive::vehicles.model_information_desc'))
                ->schema([
                    Grid::make(2)->schema([
                        Select::make('car_brand_id')
                            ->label(__('automotive::vehicles.car_brand'))
                            ->relationship('carBrand', 'name')
                            ->searchable()
                            ->required()
                            ->preload()
                            ->manageOptionForm(fn (Schema $schema) => CarBrandForm::configure($schema))
                            ->columnSpan(1),

                        TextInput::make('name')
                            ->label(__('automotive::vehicles.model_name'))
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),
                    ]),

                    Grid::make(3)->schema([
                        TextInput::make('year_from')
                            ->label(__('automotive::vehicles.year_from'))
                            ->numeric()
                            ->minValue(1900)
                            ->maxValue(2100)
                            ->placeholder('2020')
                            ->columnSpan(1),

                        TextInput::make('year_to')
                            ->label(__('automotive::vehicles.year_to'))
                            ->numeric()
                            ->minValue(1900)
                            ->maxValue(2100)
                            ->placeholder('2025')
                            ->columnSpan(1),

                        Select::make('body_type')
                            ->label(__('automotive::vehicles.body_type'))
                            ->options([
                                'sedan' => __('automotive::vehicles.body_types.sedan'),
                                'suv' => __('automotive::vehicles.body_types.suv'),
                                'hatchback' => __('automotive::vehicles.body_types.hatchback'),
                                'coupe' => __('automotive::vehicles.body_types.coupe'),
                                'convertible' => __('automotive::vehicles.body_types.convertible'),
                                'wagon' => __('automotive::vehicles.body_types.wagon'),
                                'van' => __('automotive::vehicles.body_types.van'),
                                'truck' => __('automotive::vehicles.body_types.truck'),
                            ])
                            ->searchable()
                            ->native(false)
                            ->columnSpan(1),
                    ]),

                    Toggle::make('is_active')
                        ->label(__('automotive::vehicles.is_active'))
                        ->default(true)
                        ->helperText(__('automotive::vehicles.is_active_help'))
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
