<?php

namespace Packages\Automotive\Garage\Filament\Resources\VehicleResource\Pages;

use Filament\Actions\EditAction;
use App\Library\Extensions\Pages\ViewRecord;
use Packages\Automotive\Garage\Filament\Resources\VehicleResource;

class ViewVehicle extends ViewRecord
{
    protected static string $resource = VehicleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
