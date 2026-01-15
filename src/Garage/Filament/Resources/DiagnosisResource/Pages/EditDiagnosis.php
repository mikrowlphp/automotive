<?php

namespace Packages\Automotive\Garage\Filament\Resources\DiagnosisResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use App\Library\Extensions\Pages\EditRecord;
use Packages\Automotive\Garage\Filament\Resources\DiagnosisResource;

class EditDiagnosis extends EditRecord
{
    protected static string $resource = DiagnosisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
