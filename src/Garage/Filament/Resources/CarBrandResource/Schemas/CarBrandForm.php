<?php

namespace Packages\Automotive\Garage\Filament\Resources\CarBrandResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CarBrandForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(12)
            ->components([
                Section::make()
                    ->schema([
                        // Header - Nome
                        TextInput::make('name')
                            ->label(__('automotive::vehicles.name'))
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        // Logo
                        FileUpload::make('logo')
                            ->label(__('automotive::vehicles.logo'))
                            ->image()
                            ->maxSize(2048)
                            ->directory('car-brands/logos')
                            ->visibility('public')
                            ->columnSpan(['default' => 12, 'md' => 6]),

                        // Paese e Attivo
                        Grid::make(2)->schema([
                            TextInput::make('country')
                                ->label(__('automotive::vehicles.country'))
                                ->maxLength(255),

                            Toggle::make('is_active')
                                ->label(__('automotive::vehicles.is_active'))
                                ->default(true)
                                ->helperText(__('automotive::vehicles.is_active_help')),
                        ])->columnSpanFull(),
                    ])
                    ->columns(12)
                    ->columnSpanFull(),
            ]);
    }
}
