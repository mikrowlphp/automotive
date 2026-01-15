<?php

namespace Packages\Automotive\Garage\Filament\Resources\ElectricianServiceResource\Pages;

use Filament\Actions\DeleteAction;
use App\Library\Extensions\Pages\EditRecord;
use Packages\Automotive\Garage\Filament\Resources\ElectricianServiceResource;

class EditElectricianService extends EditRecord
{
    protected static string $resource = ElectricianServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
