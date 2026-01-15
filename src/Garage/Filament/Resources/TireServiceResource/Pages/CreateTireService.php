<?php

namespace Packages\Automotive\Garage\Filament\Resources\TireServiceResource\Pages;

use App\Library\Extensions\Pages\CreateRecord;
use Packages\Automotive\Garage\Enums\ServiceType;
use Packages\Automotive\Garage\Filament\Resources\TireServiceResource;

class CreateTireService extends CreateRecord
{
    protected static string $resource = TireServiceResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['type'] = ServiceType::TIRES;

        return $data;
    }
}
