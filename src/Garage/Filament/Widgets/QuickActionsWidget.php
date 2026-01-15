<?php

namespace Packages\Automotive\Garage\Filament\Widgets;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Widgets\Widget;
use Packages\Automotive\Garage\Filament\Resources\DiagnosisResource;
use Packages\Automotive\Garage\Filament\Resources\VehicleResource;

class QuickActionsWidget extends Widget implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    protected static ?int $sort = 2;

    protected string $view = 'automotive::widgets.quick-actions';

    protected int|string|array $columnSpan = 'full';

    public function newDiagnosisAction(): Action
    {
        return Action::make('newDiagnosis')
            ->label(__('automotive::services.dashboard.new_diagnosis'))
            ->icon('heroicon-o-clipboard-document-list')
            ->color('primary')
            ->url(DiagnosisResource::getUrl('create'));
    }

    public function newVehicleAction(): Action
    {
        return Action::make('newVehicle')
            ->label(__('automotive::services.dashboard.new_vehicle'))
            ->icon('heroicon-o-truck')
            ->color('gray')
            ->url(VehicleResource::getUrl('create'));
    }
}
