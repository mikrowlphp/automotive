<?php

namespace Packages\Automotive\Garage\Filament\Resources\BodyworkServiceResource\Pages;

use Filament\Actions\DeleteAction;
use App\Library\Extensions\Pages\EditRecord;
use Packages\Automotive\Garage\Filament\Resources\BodyworkServiceResource;

class EditBodyworkService extends EditRecord
{
    protected static string $resource = BodyworkServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
