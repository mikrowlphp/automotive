<?php

namespace Packages\Automotive\Garage\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Packages\Automotive\Garage\Enums\DiagnosisStatus;
use Packages\Automotive\Garage\Enums\ServiceRecordStatus;
use Packages\Automotive\Garage\Models\Diagnosis;
use Packages\Automotive\Garage\Models\ServiceRecord;
use Packages\Automotive\Garage\Models\Vehicle;

class GarageStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // Open diagnoses (waiting to be processed)
        $openDiagnoses = Diagnosis::query()
            ->where('status', DiagnosisStatus::Open)
            ->count();

        // Service records in progress
        $inProgressServices = ServiceRecord::query()
            ->where('status', ServiceRecordStatus::InProgress)
            ->count();

        // Draft service records (scheduled but not started)
        $draftServices = ServiceRecord::query()
            ->where('status', ServiceRecordStatus::Draft)
            ->count();

        // Completed services this month
        $completedThisMonth = ServiceRecord::query()
            ->where('status', ServiceRecordStatus::Completed)
            ->whereMonth('updated_at', now()->month)
            ->whereYear('updated_at', now()->year)
            ->count();

        // Total vehicles in database
        $totalVehicles = Vehicle::count();

        return [
            Stat::make(__('automotive::services.dashboard.open_diagnoses'), $openDiagnoses)
                ->description(__('automotive::services.dashboard.waiting_evaluation'))
                ->descriptionIcon('heroicon-o-clipboard-document-list')
                ->color($openDiagnoses > 0 ? 'warning' : 'success'),

            Stat::make(__('automotive::services.dashboard.in_progress'), $inProgressServices)
                ->description(__('automotive::services.dashboard.services_in_progress'))
                ->descriptionIcon('heroicon-o-wrench-screwdriver')
                ->color($inProgressServices > 0 ? 'info' : 'gray'),

            Stat::make(__('automotive::services.dashboard.scheduled'), $draftServices)
                ->description(__('automotive::services.dashboard.waiting_to_start'))
                ->descriptionIcon('heroicon-o-clock')
                ->color($draftServices > 0 ? 'warning' : 'gray'),

            Stat::make(__('automotive::services.dashboard.completed_month'), $completedThisMonth)
                ->description(__('automotive::services.dashboard.this_month'))
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make(__('automotive::services.dashboard.total_vehicles'), $totalVehicles)
                ->description(__('automotive::services.dashboard.registered_vehicles'))
                ->descriptionIcon('heroicon-o-truck')
                ->color('primary'),
        ];
    }
}
