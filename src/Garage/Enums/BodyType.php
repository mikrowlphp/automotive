<?php

namespace Packages\Automotive\Garage\Enums;

use Filament\Support\Contracts\HasLabel;

enum BodyType: string implements HasLabel
{
    case Hatchback = 'hatchback';
    case Sedan = 'sedan';
    case Wagon = 'wagon';
    case SUV = 'suv';
    case Crossover = 'crossover';
    case Coupe = 'coupe';
    case Convertible = 'convertible';
    case Van = 'van';
    case Pickup = 'pickup';
    case MPV = 'mpv';

    public function getLabel(): string
    {
        return __('automotive::vehicles.body_types.'.$this->value);
    }
}
