<?php

namespace Packages\Automotive\Garage\Filament\Resources\DiagnosisResource\Pages;

use Filament\Actions\CreateAction;
use App\Library\Extensions\Pages\ListRecords;
use Packages\Automotive\Garage\Filament\Resources\DiagnosisResource;

class ListDiagnoses extends ListRecords
{
    protected static string $resource = DiagnosisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
