<?php

namespace Packages\Automotive\Garage\Filament\Resources\CarBrandResource\Pages;

use Filament\Actions\CreateAction;
use App\Library\Extensions\Pages\ListRecords;
use Packages\Automotive\Garage\Filament\Resources\CarBrandResource;

class ListCarBrands extends ListRecords
{
    protected static string $resource = CarBrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
