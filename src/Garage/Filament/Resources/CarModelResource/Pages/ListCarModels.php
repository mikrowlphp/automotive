<?php

namespace Packages\Automotive\Garage\Filament\Resources\CarModelResource\Pages;

use Filament\Actions\CreateAction;
use App\Library\Extensions\Pages\ListRecords;
use Packages\Automotive\Garage\Filament\Resources\CarModelResource;

class ListCarModels extends ListRecords
{
    protected static string $resource = CarModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
