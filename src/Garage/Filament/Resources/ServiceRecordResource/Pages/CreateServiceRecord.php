<?php

namespace Packages\Automotive\Garage\Filament\Resources\ServiceRecordResource\Pages;

use App\Library\Extensions\Pages\CreateRecord;
use Packages\Automotive\Garage\Filament\Resources\ServiceRecordResource;

class CreateServiceRecord extends CreateRecord
{
    protected static string $resource = ServiceRecordResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->getRecord()]);
    }
}
