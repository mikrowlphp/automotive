<?php

namespace Packages\Automotive\Garage\Filament\Resources\CarModelResource\Pages;

use App\Library\Extensions\Pages\CreateRecord;
use Packages\Automotive\Garage\Filament\Resources\CarModelResource;

class CreateCarModel extends CreateRecord
{
    protected static string $resource = CarModelResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->getRecord()]);
    }
}
