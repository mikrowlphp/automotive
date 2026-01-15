<?php

namespace Packages\Automotive\Garage\Filament\Resources\TireServiceResource\Pages;

use Filament\Actions\DeleteAction;
use App\Library\Extensions\Pages\EditRecord;
use Packages\Automotive\Garage\Filament\Resources\TireServiceResource;

class EditTireService extends EditRecord
{
    protected static string $resource = TireServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
