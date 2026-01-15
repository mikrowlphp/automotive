<?php

namespace Packages\Automotive\Garage\Filament\Resources\VehicleResource\Pages;

use Filament\Actions\CreateAction;
use App\Library\Extensions\Pages\ListRecords;
use Packages\Automotive\Garage\Filament\Resources\VehicleResource;

class ListVehicles extends ListRecords
{
    protected static string $resource = VehicleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
