<?php

namespace Packages\Automotive\Garage\Filament\Resources\DiagnosisResource\Pages;

use Filament\Actions\EditAction;
use App\Library\Extensions\Pages\ViewRecord;
use Packages\Automotive\Garage\Filament\Resources\DiagnosisResource;

class ViewDiagnosis extends ViewRecord
{
    protected static string $resource = DiagnosisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
