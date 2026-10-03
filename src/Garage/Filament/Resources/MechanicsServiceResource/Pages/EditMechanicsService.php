<?php

namespace Packages\Automotive\Garage\Filament\Resources\MechanicsServiceResource\Pages;

use Packages\Automotive\Garage\Filament\Widgets\ServiceRecordToolbar;
use Filament\Actions\DeleteAction;
use App\Library\Extensions\Pages\EditRecord;
use Packages\Automotive\Garage\Filament\Resources\MechanicsServiceResource;

class EditMechanicsService extends EditRecord
{
    protected static string $resource = MechanicsServiceResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            ServiceRecordToolbar::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
