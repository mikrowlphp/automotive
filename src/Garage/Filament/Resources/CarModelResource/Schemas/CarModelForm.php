<?php

namespace Packages\Automotive\Garage\Filament\Resources\CarModelResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Html;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Packages\Automotive\Garage\Filament\Resources\CarBrandResource\Schemas\CarBrandForm;

class CarModelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(12)
            ->components([
                Section::make([
                    // === HEADER ===
                    Section::make([
                        TextInput::make('name')
                            ->hiddenLabel()
                            ->placeholder(__('automotive::vehicles.model_name'))
                            ->required()
                            ->maxLength(255)
                            ->main()
                            ->columnSpanFull(),
                    ])->contained(false)->columnSpanFull(),

                    // === HR SEPARATOR ===
                    Html::make("<hr class='my-6 text-gray-300 w-full' />")->columnSpanFull(),

                    // === BODY ===
                    Section::make()->schema([
                        Group::make([
                            Select::make('car_brand_id')
                                ->label(__('automotive::vehicles.car_brand'))
                                ->relationship('carBrand', 'name')
                                ->searchable()
                                ->required()
                                ->preload()
                                ->manageOptionForm(fn (Schema $schema) => CarBrandForm::configure($schema))
                                ->columnSpanFull(),

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
                                ->columnSpanFull(),

                            Toggle::make('is_active')
                                ->label(__('automotive::vehicles.is_active'))
                                ->default(true)
                                ->helperText(__('automotive::vehicles.is_active_help'))
                                ->columnSpanFull(),
                        ])->inlineLabel()->columns(12)->columnSpan(['default' => 12, 'xl' => 7]),

                        Group::make([
                            TextInput::make('year_from')
                                ->label(__('automotive::vehicles.year_from'))
                                ->numeric()
                                ->minValue(1900)
                                ->maxValue(2100)
                                ->placeholder('2020')
                                ->columnSpanFull(),

                            TextInput::make('year_to')
                                ->label(__('automotive::vehicles.year_to'))
                                ->numeric()
                                ->minValue(1900)
                                ->maxValue(2100)
                                ->placeholder('2025')
                                ->columnSpanFull(),
                        ])->inlineLabel()->columns(12)->columnSpan(['default' => 12, 'xl' => 5]),
                    ])->contained(false)->columns(12)->columnSpanFull(),
                ])
                    ->columns(12)
                    ->columnSpanFull(),
            ]);
    }
}
