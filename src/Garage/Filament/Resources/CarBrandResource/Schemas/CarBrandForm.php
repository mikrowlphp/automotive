<?php

namespace Packages\Automotive\Garage\Filament\Resources\CarBrandResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Html;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CarBrandForm
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
                            ->placeholder(__('automotive::vehicles.name'))
                            ->required()
                            ->maxLength(255)
                            ->main()
                            ->columnSpanFull(),
                    ])->contained(false)->columnSpan(['default' => 12, 'xl' => 7])
                        ->columnOrder(['default' => 2, 'xl' => 1]),

                    FileUpload::make('logo')
                        ->hiddenLabel()
                        ->image()
                        ->maxSize(2048)
                        ->directory('car-brands/logos')
                        ->visibility('public')
                        ->columnSpan(['default' => 12, 'xl' => 5])
                        ->columnOrder(['default' => 1, 'xl' => 2]),

                    // === HR SEPARATOR ===
                    Html::make("<hr class='my-6 text-gray-300 w-full' />")->columnSpanFull(),

                    // === BODY ===
                    Group::make([
                        TextInput::make('country')
                            ->label(__('automotive::vehicles.country'))
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Toggle::make('is_active')
                            ->label(__('automotive::vehicles.is_active'))
                            ->default(true)
                            ->helperText(__('automotive::vehicles.is_active_help'))
                            ->columnSpanFull(),
                    ])->inlineLabel()->columns(12)->columnSpanFull(),
                ])
                    ->columns(12)
                    ->columnSpanFull(),
            ]);
    }
}
