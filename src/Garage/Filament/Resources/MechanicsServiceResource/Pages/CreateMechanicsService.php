<?php

namespace Packages\Automotive\Garage\Filament\Resources\MechanicsServiceResource\Pages;

use App\Library\Extensions\Pages\CreateRecord;
use Packages\Automotive\Garage\Enums\ServiceType;
use Packages\Automotive\Garage\Filament\Resources\MechanicsServiceResource;

class CreateMechanicsService extends CreateRecord
{
    protected static string $resource = MechanicsServiceResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['type'] = ServiceType::MECHANICS;

        return $data;
    }
}
