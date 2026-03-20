<?php

declare(strict_types=1);

use Packages\Automotive\Garage\Filament\Resources\CustomerResource\Pages\CreateCustomer;
use Packages\Automotive\Garage\Filament\Resources\CustomerResource\Pages\EditCustomer;
use Packages\Automotive\Garage\Filament\Resources\CustomerResource\Pages\ListCustomers;
use Packages\Automotive\Garage\Filament\Resources\MechanicsServiceResource\Pages\CreateMechanicsService;
use Packages\Automotive\Garage\Filament\Resources\MechanicsServiceResource\Pages\ListMechanicsServices;
use Packages\Automotive\Garage\Filament\Resources\ElectricianServiceResource\Pages\CreateElectricianService;
use Packages\Automotive\Garage\Filament\Resources\ElectricianServiceResource\Pages\ListElectricianServices;
use Packages\Automotive\Garage\Filament\Resources\TireServiceResource\Pages\CreateTireService;
use Packages\Automotive\Garage\Filament\Resources\TireServiceResource\Pages\ListTireServices;
use Packages\Automotive\Garage\Filament\Resources\BodyworkServiceResource\Pages\CreateBodyworkService;
use Packages\Automotive\Garage\Filament\Resources\BodyworkServiceResource\Pages\ListBodyworkServices;
use Packages\Sales\Shared\Models\Customer;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

uses(\Tests\Tenant\TenantTestCase::class);

/**
 * Garage Services Resources - Operational Tests
 *
 * Tests CRUD functionality for: Customer (garage), MechanicsService,
 * ElectricianService, TireService, BodyworkService resources.
 * Complements GarageResourcesTest.php which covers CarBrand, CarModel,
 * Vehicle, ServiceRecord, and Diagnosis.
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
    \Packages\Sales\Shared\Models\Customer::query()->delete();
    app()->register(\Packages\Automotive\AutomotiveServiceProvider::class);
    $this->setFilamentPanel('garage');
    \Filament\Facades\Filament::setTenant($this->testTenant, isQuiet: true);
    $this->actingAs($this->tenantOwner, 'tenant');
    \Illuminate\Support\Facades\Storage::fake('tenant');
});

// =========================================================================
// CUSTOMER RESOURCE (Garage-specific, extends shared CustomerResource)
// =========================================================================

describe('Garage CustomerResource - List Page', function () {
    it('can render list page', function () {
        livewire(ListCustomers::class)
            ->assertSuccessful();
    })->group('resource', 'garage', 'customers', 'list');

    it('can list customers', function () {
        $customers = collect([
            Customer::factory()->create(['name' => 'ZZTEST_Cliente_A']),
            Customer::factory()->create(['name' => 'ZZTEST_Cliente_B']),
            Customer::factory()->create(['name' => 'ZZTEST_Cliente_C']),
        ]);

        livewire(ListCustomers::class)
            ->searchTable('ZZTEST_Cliente')
            ->assertCountTableRecords(3);
    })->group('resource', 'garage', 'customers', 'list');
})->group('garage');

describe('Garage CustomerResource - Create/Edit', function () {
    it('can render create page', function () {
        livewire(CreateCustomer::class)
            ->assertSuccessful();
    })->group('resource', 'garage', 'customers', 'create');

    it('can create a garage customer', function () {
        livewire(CreateCustomer::class)
            ->fillForm([
                'type' => 'company',
                'name' => 'Cliente Officina Srl',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        assertDatabaseHas(Customer::class, ['name' => 'Cliente Officina Srl']);
    })->group('resource', 'garage', 'customers', 'create');

    it('can render edit page', function () {
        $customer = Customer::factory()->create();

        livewire(EditCustomer::class, ['record' => $customer->id])
            ->assertSuccessful();
    })->group('resource', 'garage', 'customers', 'edit');
})->group('garage');

// =========================================================================
// MECHANICS SERVICE RESOURCE
// =========================================================================

describe('MechanicsServiceResource - List/Create', function () {
    it('can render list page', function () {
        livewire(ListMechanicsServices::class)
            ->assertSuccessful();
    })->group('resource', 'garage', 'mechanics-service', 'list');

    it('can render create page', function () {
        livewire(CreateMechanicsService::class)
            ->assertSuccessful();
    })->group('resource', 'garage', 'mechanics-service', 'create');
})->group('garage');

// =========================================================================
// ELECTRICIAN SERVICE RESOURCE
// =========================================================================

describe('ElectricianServiceResource - List/Create', function () {
    it('can render list page', function () {
        livewire(ListElectricianServices::class)
            ->assertSuccessful();
    })->group('resource', 'garage', 'electrician-service', 'list');

    it('can render create page', function () {
        livewire(CreateElectricianService::class)
            ->assertSuccessful();
    })->group('resource', 'garage', 'electrician-service', 'create');
})->group('garage');

// =========================================================================
// TIRE SERVICE RESOURCE
// =========================================================================

describe('TireServiceResource - List/Create', function () {
    it('can render list page', function () {
        livewire(ListTireServices::class)
            ->assertSuccessful();
    })->group('resource', 'garage', 'tire-service', 'list');

    it('can render create page', function () {
        livewire(CreateTireService::class)
            ->assertSuccessful();
    })->group('resource', 'garage', 'tire-service', 'create');
})->group('garage');

// =========================================================================
// BODYWORK SERVICE RESOURCE
// =========================================================================

describe('BodyworkServiceResource - List/Create', function () {
    it('can render list page', function () {
        livewire(ListBodyworkServices::class)
            ->assertSuccessful();
    })->group('resource', 'garage', 'bodywork-service', 'list');

    it('can render create page', function () {
        livewire(CreateBodyworkService::class)
            ->assertSuccessful();
    })->group('resource', 'garage', 'bodywork-service', 'create');
})->group('garage');
