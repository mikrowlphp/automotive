<?php

declare(strict_types=1);

use Packages\Automotive\Garage\Enums\DiagnosisStatus;
use Packages\Automotive\Garage\Enums\ServiceRecordStatus;
use Packages\Automotive\Garage\Enums\ServiceType;
use Packages\Automotive\Garage\Filament\Resources\DiagnosisResource\Pages\EditDiagnosis;
use Packages\Automotive\Garage\Filament\Resources\MechanicsServiceResource\Pages\EditMechanicsService;
use Packages\Automotive\Garage\Filament\Resources\ServiceRecordResource\Pages\EditServiceRecord;
use Packages\Automotive\Garage\Filament\Resources\TireServiceResource\Pages\EditTireService;
use Packages\Automotive\Garage\Filament\Widgets\DiagnosisToolbar;
use Packages\Automotive\Garage\Filament\Widgets\ServiceRecordToolbar;
use Packages\Automotive\Garage\Models\Diagnosis;
use Packages\Automotive\Garage\Models\ServiceRecord;

use function Pest\Livewire\livewire;

uses(\Tests\Tenant\TenantTestCase::class);

beforeEach(function () {
    $this->ensureModulesInstalled(['employees', 'garage']);
    app()->register(\Packages\Automotive\AutomotiveServiceProvider::class);
    $this->setFilamentPanel('garage');
    \Filament\Facades\Filament::setTenant($this->testTenant, isQuiet: true);
    $this->actingAs($this->tenantOwner, 'tenant');
});

it('shows the service record toolbar on the generic and the typed edit pages', function (string $page, ServiceType $type) {
    $record = ServiceRecord::factory()->create(['type' => $type]);

    livewire($page, ['record' => $record->getRouteKey()])
        ->assertSuccessful()
        ->assertSeeLivewire(ServiceRecordToolbar::class);
})->with([
    'generic' => [EditServiceRecord::class, ServiceType::Mechanics],
    'mechanics' => [EditMechanicsService::class, ServiceType::Mechanics],
    'tires' => [EditTireService::class, ServiceType::Tires],
]);

it('starts, completes and never brings a started service back to draft', function () {
    $record = ServiceRecord::factory()->create();

    livewire(ServiceRecordToolbar::class, ['record' => $record])->callAction('start');
    expect($record->fresh()->status)->toBe(ServiceRecordStatus::InProgress);

    livewire(ServiceRecordToolbar::class, ['record' => $record->fresh()])->call('setStatus', ServiceRecordStatus::Draft->value);
    expect($record->fresh()->status)->toBe(ServiceRecordStatus::InProgress);

    livewire(ServiceRecordToolbar::class, ['record' => $record->fresh()])->callAction('complete');
    expect($record->fresh()->status)->toBe(ServiceRecordStatus::Completed);
});

it('cancels and reopens a service', function () {
    $record = ServiceRecord::factory()->create();

    livewire(ServiceRecordToolbar::class, ['record' => $record])->callAction('cancel');
    expect($record->fresh()->status)->toBe(ServiceRecordStatus::Cancelled);

    livewire(ServiceRecordToolbar::class, ['record' => $record->fresh()])->callAction('reopen');
    expect($record->fresh()->status)->toBe(ServiceRecordStatus::Draft);
});

it('opens and closes a diagnosis from its toolbar', function () {
    $diagnosis = Diagnosis::factory()->create(['status' => DiagnosisStatus::Draft]);

    livewire(EditDiagnosis::class, ['record' => $diagnosis->getRouteKey()])
        ->assertSuccessful()
        ->assertSeeLivewire(DiagnosisToolbar::class);

    livewire(DiagnosisToolbar::class, ['record' => $diagnosis])->callAction('open');
    livewire(DiagnosisToolbar::class, ['record' => $diagnosis->fresh()])->callAction('close');
    expect($diagnosis->fresh()->status)->toBe(DiagnosisStatus::Closed);

    livewire(DiagnosisToolbar::class, ['record' => $diagnosis->fresh()])->call('setStatus', DiagnosisStatus::Draft->value);
    expect($diagnosis->fresh()->status)->toBe(DiagnosisStatus::Closed);
});
