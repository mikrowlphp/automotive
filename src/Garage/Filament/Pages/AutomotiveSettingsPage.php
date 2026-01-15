<?php

namespace Packages\Automotive\Garage\Filament\Pages;

use App\Library\Pages\SettingsPage;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AutomotiveSettingsPage extends SettingsPage
{
    // ✅ REQUIRED: Module identifier for settings storage
    protected static string $module = 'services';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('automotive::services.settings.service_types.title'))
                    ->description(__('automotive::services.settings.service_types.description'))
                    ->aside()
                    ->schema([
                        Toggle::make('enable_mechanics')
                            ->label(__('automotive::services.settings.service_types.mechanics'))
                            ->helperText(__('automotive::services.settings.service_types.mechanics_help'))
                            ->default(true),

                        Toggle::make('enable_bodywork')
                            ->label(__('automotive::services.settings.service_types.bodywork'))
                            ->helperText(__('automotive::services.settings.service_types.bodywork_help'))
                            ->default(true),

                        Toggle::make('enable_tires')
                            ->label(__('automotive::services.settings.service_types.tires'))
                            ->helperText(__('automotive::services.settings.service_types.tires_help'))
                            ->default(true),

                        Toggle::make('enable_electrician')
                            ->label(__('automotive::services.settings.service_types.electrician'))
                            ->helperText(__('automotive::services.settings.service_types.electrician_help'))
                            ->default(true),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');  // ✅ REQUIRED: Settings use 'data' state path
    }

    public function getHeading(): string
    {
        return __('automotive::services.settings.heading');
    }

    public static function getNavigationLabel(): string
    {
        return __('automotive::services.settings.navigation_label');
    }
}
