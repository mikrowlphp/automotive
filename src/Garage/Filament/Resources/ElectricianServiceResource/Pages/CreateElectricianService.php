<?php

namespace Packages\Automotive\Garage\Filament\Resources\ElectricianServiceResource\Pages;

use App\Library\Extensions\Pages\CreateRecord;
use Packages\Automotive\Garage\Enums\ServiceType;
use Packages\Automotive\Garage\Filament\Resources\ElectricianServiceResource;

class CreateElectricianService extends CreateRecord
{
    protected static string $resource = ElectricianServiceResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['type'] = ServiceType::ELECTRICIAN;

        return $data;
    }
}
