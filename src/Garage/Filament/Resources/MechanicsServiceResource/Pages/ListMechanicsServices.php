<?php

namespace Packages\Automotive\Garage\Filament\Resources\MechanicsServiceResource\Pages;

use Filament\Actions\CreateAction;
use App\Library\Extensions\Pages\ListRecords;
use Packages\Automotive\Garage\Filament\Resources\MechanicsServiceResource;

class ListMechanicsServices extends ListRecords
{
    protected static string $resource = MechanicsServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
