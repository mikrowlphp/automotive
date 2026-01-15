<?php

namespace Packages\Automotive\Garage\Filament\Resources\ElectricianServiceResource\Pages;

use Filament\Actions\CreateAction;
use App\Library\Extensions\Pages\ListRecords;
use Packages\Automotive\Garage\Filament\Resources\ElectricianServiceResource;

class ListElectricianServices extends ListRecords
{
    protected static string $resource = ElectricianServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
