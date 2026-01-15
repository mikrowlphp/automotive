<?php

namespace Packages\Automotive\Garage\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum DiagnosisStatus: string implements HasColor, HasIcon, HasLabel
{
    case Draft = 'draft';
    case Open = 'open';
    case Closed = 'closed';

    public function getLabel(): string
    {
        return __('automotive::services.diagnosis_statuses.'.$this->value);
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Draft => 'gray',
            self::Open => 'warning',
            self::Closed => 'success',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Draft => 'heroicon-o-document',
            self::Open => 'heroicon-o-clipboard-document-check',
            self::Closed => 'heroicon-o-check-circle',
        };
    }
}
