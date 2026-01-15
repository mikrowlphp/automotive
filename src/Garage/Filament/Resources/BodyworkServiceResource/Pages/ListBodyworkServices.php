<?php

namespace Packages\Automotive\Garage\Filament\Resources\BodyworkServiceResource\Pages;

use Filament\Actions\CreateAction;
use App\Library\Extensions\Pages\ListRecords;
use Packages\Automotive\Garage\Filament\Resources\BodyworkServiceResource;

class ListBodyworkServices extends ListRecords
{
    protected static string $resource = BodyworkServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
