<?php

namespace Packages\Automotive\Garage\Filament\Resources\ServiceRecordResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use App\Library\Extensions\Pages\EditRecord;
use Packages\Automotive\Garage\Filament\Resources\ServiceRecordResource;

class EditServiceRecord extends EditRecord
{
    protected static string $resource = ServiceRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
