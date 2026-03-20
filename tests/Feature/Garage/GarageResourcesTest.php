<?php

declare(strict_types=1);

use Livewire\Livewire;
use Packages\Automotive\Garage\Filament\Resources\CarBrandResource\Pages\CreateCarBrand;
use Packages\Automotive\Garage\Filament\Resources\CarBrandResource\Pages\EditCarBrand;
use Packages\Automotive\Garage\Filament\Resources\CarBrandResource\Pages\ListCarBrands;
use Packages\Automotive\Garage\Filament\Resources\CarModelResource\Pages\CreateCarModel;
use Packages\Automotive\Garage\Filament\Resources\CarModelResource\Pages\EditCarModel;
use Packages\Automotive\Garage\Filament\Resources\CarModelResource\Pages\ListCarModels;
use Packages\Automotive\Garage\Filament\Resources\VehicleResource\Pages\CreateVehicle;
use Packages\Automotive\Garage\Filament\Resources\VehicleResource\Pages\ListVehicles;
use Packages\Automotive\Garage\Filament\Resources\ServiceRecordResource\Pages\ListServiceRecords;
use Packages\Automotive\Garage\Filament\Resources\DiagnosisResource\Pages\ListDiagnoses;
use Packages\Automotive\Garage\Models\CarBrand;
use Packages\Automotive\Garage\Models\CarModel;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Livewire\livewire;

uses(\Tests\Tenant\TenantTestCase::class);

/**
 * Garage Resources - Operational Tests
 *
 * Tests CRUD functionality for: CarBrand, CarModel, and listing for Vehicle/ServiceRecord/Diagnosis.
 */

$moduleInstalled = false;

beforeEach(function () use (&$moduleInstalled) {
    if (!$moduleInstalled) {
        foreach (['garage', 'sales', 'employees'] as $slug) {
            if (\App\Models\Tenant\Module::where('slug', $slug)->exists()) {
                $this->uninstallModule($slug);
            }
        }
        $this->ensureModulesInstalled(['employees', 'garage']);
        $moduleInstalled = true;
    }
    // Data cleanup between tests
    \Packages\Automotive\Garage\Models\CarModel::query()->delete();
    \Packages\Automotive\Garage\Models\CarBrand::query()->delete();
    app()->register(\Packages\Automotive\AutomotiveServiceProvider::class);
    $this->setFilamentPanel('garage');
    \Filament\Facades\Filament::setTenant($this->testTenant, isQuiet: true);
    $this->actingAs($this->tenantOwner, 'tenant');
    \Illuminate\Support\Facades\Storage::fake('tenant');
});

// =========================================================================
// CAR BRAND RESOURCE
// =========================================================================

describe('CarBrandResource - List Page', function () {
    it('can render list page', function () {
        livewire(ListCarBrands::class)
            ->assertSuccessful();
    })->group('resource', 'garage', 'car-brands', 'list');

    it('can list car brands', function () {
        CarBrand::create(['name' => 'ZZTEST_Marca_A']);
        CarBrand::create(['name' => 'ZZTEST_Marca_B']);
        CarBrand::create(['name' => 'ZZTEST_Marca_C']);

        livewire(ListCarBrands::class)
            ->searchTable('ZZTEST_Marca')
            ->assertCountTableRecords(3);
    })->group('resource', 'garage', 'car-brands', 'list');

    it('can search car brands by name', function () {
        $brand1 = CarBrand::create(['name' => 'ZZTEST_Cerca_A']);
        $brand2 = CarBrand::create(['name' => 'ZZTEST_Cerca_B']);

        livewire(ListCarBrands::class)
            ->searchTable('ZZTEST_Cerca_A')
            ->assertCanSeeTableRecords([$brand1])
            ->assertCanNotSeeTableRecords([$brand2]);
    })->group('resource', 'garage', 'car-brands', 'list');
})->group('garage');

describe('CarBrandResource - Create Page', function () {
    it('can render create page', function () {
        livewire(CreateCarBrand::class)
            ->assertSuccessful();
    })->group('resource', 'garage', 'car-brands', 'create');

    it('can create a car brand', function () {
        livewire(CreateCarBrand::class)
            ->fillForm([
                'name' => 'ZZTEST_Maserati',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        assertDatabaseHas(CarBrand::class, ['name' => 'ZZTEST_Maserati']);
    })->group('resource', 'garage', 'car-brands', 'create');

    it('validates that name is required', function () {
        livewire(CreateCarBrand::class)
            ->fillForm(['name' => null])
            ->call('create')
            ->assertHasFormErrors(['name' => 'required']);
    })->group('resource', 'garage', 'car-brands', 'validation');
})->group('garage');

describe('CarBrandResource - Edit Page', function () {
    it('can render edit page', function () {
        $brand = CarBrand::create(['name' => 'ZZTEST_Edit_Brand']);

        livewire(EditCarBrand::class, ['record' => $brand->id])
            ->assertSuccessful();
    })->group('resource', 'garage', 'car-brands', 'edit');

    it('can update a car brand', function () {
        $brand = CarBrand::create(['name' => 'ZZTEST_Old_Brand']);

        livewire(EditCarBrand::class, ['record' => $brand->id])
            ->fillForm(['name' => 'ZZTEST_New_Brand'])
            ->call('save')
            ->assertHasNoFormErrors();

        expect($brand->fresh()->name)->toBe('ZZTEST_New_Brand');
    })->group('resource', 'garage', 'car-brands', 'edit');

    it('can delete a car brand', function () {
        $brand = CarBrand::create(['name' => 'ZZTEST_Delete_Brand']);

        livewire(EditCarBrand::class, ['record' => $brand->id])
            ->callAction('delete');

        assertDatabaseMissing(CarBrand::class, ['id' => $brand->id]);
    })->group('resource', 'garage', 'car-brands', 'delete');
})->group('garage');

// =========================================================================
// CAR MODEL RESOURCE
// =========================================================================

describe('CarModelResource - List Page', function () {
    it('can render list page', function () {
        livewire(ListCarModels::class)
            ->assertSuccessful();
    })->group('resource', 'garage', 'car-models', 'list');

    it('can list car models', function () {
        $brand = CarBrand::create(['name' => 'ZZTEST_Brand_Models']);
        $model1 = CarModel::create(['name' => 'ZZTEST_Modello_A', 'car_brand_id' => $brand->id]);
        $model2 = CarModel::create(['name' => 'ZZTEST_Modello_B', 'car_brand_id' => $brand->id]);

        livewire(ListCarModels::class)
            ->searchTable('ZZTEST_Modello')
            ->assertCanSeeTableRecords([$model1, $model2])
            ->assertCountTableRecords(2);
    })->group('resource', 'garage', 'car-models', 'list');
})->group('garage');

describe('CarModelResource - Create Page', function () {
    it('can render create page', function () {
        livewire(CreateCarModel::class)
            ->assertSuccessful();
    })->group('resource', 'garage', 'car-models', 'create');

    it('can create a car model', function () {
        $brand = CarBrand::create(['name' => 'ZZTEST_Brand_Create']);

        livewire(CreateCarModel::class)
            ->fillForm([
                'name'         => 'ZZTEST_SF90',
                'car_brand_id' => $brand->id,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        assertDatabaseHas(CarModel::class, [
            'name'         => 'ZZTEST_SF90',
            'car_brand_id' => $brand->id,
        ]);
    })->group('resource', 'garage', 'car-models', 'create');
})->group('garage');

describe('CarModelResource - Edit Page', function () {
    it('can render edit page', function () {
        $brand = CarBrand::create(['name' => 'ZZTEST_Brand_EditModel']);
        $model = CarModel::create(['name' => 'ZZTEST_Model_Edit', 'car_brand_id' => $brand->id]);

        livewire(EditCarModel::class, ['record' => $model->id])
            ->assertSuccessful();
    })->group('resource', 'garage', 'car-models', 'edit');

    it('can update a car model', function () {
        $brand = CarBrand::create(['name' => 'ZZTEST_Brand_Update']);
        $model = CarModel::create(['name' => 'ZZTEST_Old_Model', 'car_brand_id' => $brand->id]);

        livewire(EditCarModel::class, ['record' => $model->id])
            ->fillForm(['name' => 'ZZTEST_Updated_Model'])
            ->call('save')
            ->assertHasNoFormErrors();

        expect($model->fresh()->name)->toBe('ZZTEST_Updated_Model');
    })->group('resource', 'garage', 'car-models', 'edit');
})->group('garage');

// =========================================================================
// OTHER RESOURCES - List page only (no factory available yet)
// =========================================================================

describe('VehicleResource - List Page', function () {
    it('can render list page', function () {
        livewire(ListVehicles::class)
            ->assertSuccessful();
    })->group('resource', 'garage', 'vehicles', 'list');

    it('can render create page', function () {
        livewire(CreateVehicle::class)
            ->assertSuccessful();
    })->group('resource', 'garage', 'vehicles', 'create');
})->group('garage');

describe('ServiceRecordResource - List Page', function () {
    it('can render list page', function () {
        livewire(ListServiceRecords::class)
            ->assertSuccessful();
    })->group('resource', 'garage', 'service-records', 'list');
})->group('garage');

describe('DiagnosisResource - List Page', function () {
    it('can render list page', function () {
        livewire(ListDiagnoses::class)
            ->assertSuccessful();
    })->group('resource', 'garage', 'diagnoses', 'list');
})->group('garage');
