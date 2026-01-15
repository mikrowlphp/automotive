<?php

namespace Packages\Automotive\Garage\Filament\Resources\BodyworkServiceResource\Pages;

use App\Library\Extensions\Pages\CreateRecord;
use Packages\Automotive\Garage\Enums\ServiceType;
use Packages\Automotive\Garage\Filament\Resources\BodyworkServiceResource;

class CreateBodyworkService extends CreateRecord
{
    protected static string $resource = BodyworkServiceResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['type'] = ServiceType::BODYWORK;

        return $data;
    }
}
