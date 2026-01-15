<?php

namespace Packages\Automotive\Garage\Filament\Resources\CarModelResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Html;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Packages\Automotive\Garage\Filament\Resources\CarBrandResource\Schemas\CarBrandForm;

class CarModelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->schema([
                // HEADER ZONE - Name field only (fullspan)
                Grid::make(12)->schema([
                    TextInput::make('name')
                        ->hiddenLabel()
                        ->placeholder(__('automotive::vehicles.model_name'))
                        ->required()
                        ->main()
                        ->maxLength(255)
                        ->columnSpanFull(),
                ])->columnSpanFull(),

                // IMPORTANT INFO ZONE - Brand selection (key entity info)
                Grid::make(12)->schema([
                    Select::make('car_brand_id')
                        ->hiddenLabel()
                        ->placeholder(__('automotive::vehicles.car_brand'))
                        ->relationship('carBrand', 'name')
                        ->searchable()
                        ->required()
                        ->preload()
                        ->manageOptionForm(fn (Schema $schema) => CarBrandForm::configure($schema))
                        ->columnSpan(['default' => 12, 'xl' => 6]),
                ])->columnSpanFull(),

                // SEPARATOR
                Html::make("<hr class='my-6 text-gray-300 w-full' />")->columnSpanFull(),

                // BODY ZONE - 7/5 column split
                Section::make()
                    ->schema([
                        Group::make([
                            // Left column - Main fields
                            TextInput::make('year_from')
                                ->label(__('automotive::vehicles.year_from'))
                                ->numeric()
                                ->minValue(1900)
                                ->maxValue(2100)
                                ->placeholder('2020'),

                            TextInput::make('year_to')
                                ->label(__('automotive::vehicles.year_to'))
                                ->numeric()
                                ->minValue(1900)
                                ->maxValue(2100)
                                ->placeholder('2025'),

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
                                ->native(false),
                        ])->inlineLabel()->columns(12)->columnSpan([
                            'default' => 12,
                            'xl' => 7,
                        ]),

                        Group::make([
                            // Right column - Secondary fields
                            Toggle::make('is_active')
                                ->label(__('automotive::vehicles.is_active'))
                                ->default(true)
                                ->helperText(__('automotive::vehicles.is_active_help')),
                        ])->inlineLabel()->columns(12)->columnSpan([
                            'default' => 12,
                            'xl' => 5,
                        ]),
                    ])
                    ->contained(false)
                    ->columns(12)
                    ->columnSpanFull(),
            ])->columns(12)->columnSpanFull(),
        ]);
    }
}
