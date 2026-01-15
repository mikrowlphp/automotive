<?php

namespace Packages\Automotive\Garage\Filament\Resources\MechanicsServiceResource\Pages;

use Filament\Actions\DeleteAction;
use App\Library\Extensions\Pages\EditRecord;
use Packages\Automotive\Garage\Filament\Resources\MechanicsServiceResource;

class EditMechanicsService extends EditRecord
{
    protected static string $resource = MechanicsServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
