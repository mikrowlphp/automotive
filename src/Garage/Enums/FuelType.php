<?php

namespace Packages\Automotive\Garage\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum FuelType: string implements HasColor, HasIcon, HasLabel
{
    case Petrol = 'petrol';
    case Diesel = 'diesel';
    case Electric = 'electric';
    case Hybrid = 'hybrid';
    case PluginHybrid = 'plugin_hybrid';
    case LPG = 'lpg';
    case CNG = 'cng';
    case Hydrogen = 'hydrogen';

    public function getLabel(): string
    {
        return __('automotive::vehicles.fuel_types.'.$this->value);
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Petrol => 'warning',
            self::Diesel => 'gray',
            self::Electric => 'success',
            self::Hybrid => 'info',
            self::PluginHybrid => 'primary',
            self::LPG => 'warning',
            self::CNG => 'info',
            self::Hydrogen => 'success',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Petrol => 'heroicon-o-fire',
            self::Diesel => 'heroicon-o-beaker',
            self::Electric => 'heroicon-o-bolt',
            self::Hybrid, self::PluginHybrid => 'heroicon-o-battery-50',
            self::LPG, self::CNG => 'heroicon-o-cube',
            self::Hydrogen => 'heroicon-o-sparkles',
        };
    }
}
