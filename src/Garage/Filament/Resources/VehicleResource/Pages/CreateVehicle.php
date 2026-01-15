<?php

namespace Packages\Automotive\Garage\Filament\Resources\VehicleResource\Pages;

use App\Library\Extensions\Pages\CreateRecord;
use Packages\Automotive\Garage\Filament\Resources\VehicleResource;

class CreateVehicle extends CreateRecord
{
    protected static string $resource = VehicleResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }
}
