<?php

namespace Packages\Automotive\Garage\Filament\Resources\ServiceRecordResource\Pages;

use Filament\Actions\CreateAction;
use App\Library\Extensions\Pages\ListRecords;
use Packages\Automotive\Garage\Filament\Resources\ServiceRecordResource;

class ListServiceRecords extends ListRecords
{
    protected static string $resource = ServiceRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
