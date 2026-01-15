<?php

namespace Packages\Automotive\Garage\Filament\Resources\CarBrandResource\Pages;

use Filament\Actions\DeleteAction;
use App\Library\Extensions\Pages\EditRecord;
use Packages\Automotive\Garage\Filament\Resources\CarBrandResource;

class EditCarBrand extends EditRecord
{
    protected static string $resource = CarBrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
