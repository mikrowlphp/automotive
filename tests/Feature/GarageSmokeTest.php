<?php

use Livewire\Livewire;
use Packages\Automotive\Garage\Filament\Resources\CarBrandResource\Pages\CreateCarBrand;
use Packages\Automotive\Garage\Filament\Resources\CarBrandResource\Pages\EditCarBrand;
use Packages\Automotive\Garage\Filament\Resources\CarBrandResource\Pages\ListCarBrands;
use Packages\Automotive\Garage\Filament\Resources\CarModelResource\Pages\CreateCarModel;
use Packages\Automotive\Garage\Filament\Resources\CarModelResource\Pages\EditCarModel;
use Packages\Automotive\Garage\Filament\Resources\CarModelResource\Pages\ListCarModels;
use Packages\Automotive\Garage\Filament\Resources\VehicleResource\Pages\CreateVehicle;
use Packages\Automotive\Garage\Filament\Resources\VehicleResource\Pages\EditVehicle;
use Packages\Automotive\Garage\Filament\Resources\VehicleResource\Pages\ListVehicles;
use Packages\Automotive\Garage\Filament\Resources\ServiceRecordResource\Pages\CreateServiceRecord;
use Packages\Automotive\Garage\Filament\Resources\ServiceRecordResource\Pages\EditServiceRecord;
use Packages\Automotive\Garage\Filament\Resources\ServiceRecordResource\Pages\ListServiceRecords;
use Packages\Automotive\Garage\Filament\Resources\DiagnosisResource\Pages\CreateDiagnosis;
use Packages\Automotive\Garage\Filament\Resources\DiagnosisResource\Pages\EditDiagnosis;
use Packages\Automotive\Garage\Filament\Resources\DiagnosisResource\Pages\ListDiagnoses;
use Packages\Automotive\Garage\Models\CarBrand;
use Packages\Automotive\Garage\Models\CarModel;
use Packages\Automotive\Garage\Models\Vehicle;

uses(\Tests\Tenant\TenantTestCase::class);

/**
 * Garage Module Smoke Tests
 *
 * MANDATORY: These tests must pass after every change to this module.
 * 1. Module can be installed and uninstalled
 * 2. All Filament pages render without errors (List / Create / Edit)
 *
 * Dependencies: sales (for inventory/products infrastructure)
 */

beforeEach(function () {
    $this->ensureModulesInstalled(['employees', 'garage']);
    app()->register(\Packages\Automotive\AutomotiveServiceProvider::class);
    $this->setFilamentPanel('garage');
    \Filament\Facades\Filament::setTenant($this->testTenant, isQuiet: true);
    $this->actingAs($this->tenantOwner, 'tenant');
    \Illuminate\Support\Facades\Storage::fake('tenant');
});

afterEach(function () {
    if (\App\Models\Tenant\Module::where('slug', 'garage')->exists()) {
        $this->uninstallModule('garage');
    }
});

describe('Module Lifecycle', function () {
    it('can be installed and uninstalled', function () {
        $this->assertModuleInstalled('garage');
        $this->assertModuleHasMigrations('garage');
        $this->assertModuleBelongsToPackage('garage', 'automotive');

        $this->uninstallModule('garage');
        $this->assertModuleNotInstalled('garage');

        $this->ensureModulesInstalled(['garage']);
    })->group('smoke', 'lifecycle');
})->group('garage');

describe('Page Rendering - CarBrand Resource', function () {
    it('can render List page', function () {
        Livewire::test(ListCarBrands::class)->assertSuccessful();
    })->group('smoke', 'pages', 'resources');

    it('can render Create page', function () {
        Livewire::test(CreateCarBrand::class)->assertSuccessful();
    })->group('smoke', 'pages', 'resources');

    it('can render Edit page', function () {
        $brand = CarBrand::create(['name' => 'Test Brand']);
        Livewire::test(EditCarBrand::class, ['record' => $brand->id])->assertSuccessful();
    })->group('smoke', 'pages', 'resources');
})->group('garage');

describe('Page Rendering - CarModel Resource', function () {
    it('can render List page', function () {
        Livewire::test(ListCarModels::class)->assertSuccessful();
    })->group('smoke', 'pages', 'resources');

    it('can render Create page', function () {
        Livewire::test(CreateCarModel::class)->assertSuccessful();
    })->group('smoke', 'pages', 'resources');

    it('can render Edit page', function () {
        $brand = CarBrand::create(['name' => 'Test Brand']);
        $model = CarModel::create(['name' => 'Test Model', 'car_brand_id' => $brand->id]);
        Livewire::test(EditCarModel::class, ['record' => $model->id])->assertSuccessful();
    })->group('smoke', 'pages', 'resources');
})->group('garage');

describe('Page Rendering - Vehicle Resource', function () {
    it('can render List page', function () {
        Livewire::test(ListVehicles::class)->assertSuccessful();
    })->group('smoke', 'pages', 'resources');

    it('can render Create page', function () {
        Livewire::test(CreateVehicle::class)->assertSuccessful();
    })->group('smoke', 'pages', 'resources');

    it('can render Edit page', function () {
        $vehicle = Vehicle::factory()->create();
        Livewire::test(EditVehicle::class, ['record' => $vehicle->id])->assertSuccessful();
    })->group('smoke', 'pages', 'resources');
})->group('garage');

describe('Page Rendering - ServiceRecord Resource', function () {
    it('can render List page', function () {
        Livewire::test(ListServiceRecords::class)->assertSuccessful();
    })->group('smoke', 'pages', 'resources');

    it('can render Create page', function () {
        Livewire::test(CreateServiceRecord::class)->assertSuccessful();
    })->group('smoke', 'pages', 'resources');

    it('can render Edit page', function () {
        $record = \Packages\Automotive\Garage\Models\ServiceRecord::factory()->create();
        Livewire::test(EditServiceRecord::class, ['record' => $record->id])->assertSuccessful();
    })->group('smoke', 'pages', 'resources');
})->group('garage');

describe('Page Rendering - Diagnosis Resource', function () {
    it('can render List page', function () {
        Livewire::test(ListDiagnoses::class)->assertSuccessful();
    })->group('smoke', 'pages', 'resources');

    it('can render Create page', function () {
        Livewire::test(CreateDiagnosis::class)->assertSuccessful();
    })->group('smoke', 'pages', 'resources');

    it('can render Edit page', function () {
        $diagnosis = \Packages\Automotive\Garage\Models\Diagnosis::factory()->create();
        Livewire::test(EditDiagnosis::class, ['record' => $diagnosis->id])->assertSuccessful();
    })->group('smoke', 'pages', 'resources');
})->group('garage');
