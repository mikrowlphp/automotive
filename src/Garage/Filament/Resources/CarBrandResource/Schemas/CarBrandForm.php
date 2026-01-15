<?php

namespace Packages\Automotive\Garage\Filament\Resources\CarBrandResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Html;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CarBrandForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->schema([
                // HEADER ZONE - Name field only (fullspan)
                Grid::make(12)->schema([
                    TextInput::make('name')
                        ->hiddenLabel()
                        ->placeholder(__('automotive::vehicles.name'))
                        ->required()
                        ->main()
                        ->maxLength(255)
                        ->columnSpanFull(),
                ])->columnSpanFull(),

                // IMPORTANT INFO ZONE - Logo (image, allowed next to name zone conceptually, but here standalone)
                Grid::make(12)->schema([
                    FileUpload::make('logo')
                        ->hiddenLabel()
                        ->image()
                        ->maxSize(2048)
                        ->directory('car-brands/logos')
                        ->visibility('public')
                        ->columnSpan(['default' => 12, 'xl' => 6]),
                ])->columnSpanFull(),

                // SEPARATOR
                Html::make("<hr class='my-6 text-gray-300 w-full' />")->columnSpanFull(),

                // BODY ZONE - 7/5 column split
                Section::make()
                    ->schema([
                        Group::make([
                            // Left column - Main fields
                            TextInput::make('country')
                                ->label(__('automotive::vehicles.country'))
                                ->maxLength(255),
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
