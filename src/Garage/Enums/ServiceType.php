<?php

namespace Packages\Automotive\Garage\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ServiceType: string implements HasColor, HasIcon, HasLabel
{
    case Mechanics = 'mechanics';
    case Bodywork = 'bodywork';
    case Tires = 'tires';
    case Electrician = 'electrician';

    public function getLabel(): string
    {
        return __('automotive::services.types.'.$this->value);
    }

    public function getIcon(): string|null|\BackedEnum
    {
        return match ($this) {
            self::Mechanics => 'heroicon-o-wrench-screwdriver',
            self::Bodywork => 'heroicon-o-truck',
            self::Tires => 'heroicon-o-circle-stack',
            self::Electrician => 'heroicon-o-bolt',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Mechanics => 'primary',
            self::Bodywork => 'warning',
            self::Tires => 'success',
            self::Electrician => 'info',
        };
    }
}
