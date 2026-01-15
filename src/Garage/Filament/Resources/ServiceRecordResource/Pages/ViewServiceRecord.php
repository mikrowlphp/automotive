<?php

namespace Packages\Automotive\Garage\Filament\Resources\ServiceRecordResource\Pages;

use Filament\Actions\EditAction;
use App\Library\Extensions\Pages\ViewRecord;
use Packages\Automotive\Garage\Filament\Resources\ServiceRecordResource;

class ViewServiceRecord extends ViewRecord
{
    protected static string $resource = ServiceRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
