<?php

namespace Packages\Automotive\Garage\Filament\Resources\CarBrandResource\Pages;

use App\Library\Extensions\Pages\CreateRecord;
use Packages\Automotive\Garage\Filament\Resources\CarBrandResource;

class CreateCarBrand extends CreateRecord
{
    protected static string $resource = CarBrandResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->getRecord()]);
    }
}
