<?php

namespace Packages\Automotive\Garage\Enums;

use Filament\Support\Contracts\HasLabel;

enum TransmissionType: string implements HasLabel
{
    case Manual = 'manual';
    case Automatic = 'automatic';
    case SemiAutomatic = 'semi_automatic';
    case CVT = 'cvt';

    public function getLabel(): string
    {
        return __('automotive::vehicles.transmission_types.'.$this->value);
    }
}
