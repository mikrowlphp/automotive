<?php

namespace Packages\Automotive\Garage\Enums;

use Filament\Support\Contracts\HasLabel;

enum ServiceLineType: string implements HasLabel
{
    case Labor = 'labor';
    case Part = 'part';
    case Other = 'other';

    public function getLabel(): string
    {
        return __('automotive::services.line_types.'.$this->value);
    }
}
