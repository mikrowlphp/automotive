<?php

namespace Packages\Automotive\Garage\Filament\Resources\TireServiceResource\Pages;

use Filament\Actions\CreateAction;
use App\Library\Extensions\Pages\ListRecords;
use Packages\Automotive\Garage\Filament\Resources\TireServiceResource;

class ListTireServices extends ListRecords
{
    protected static string $resource = TireServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
