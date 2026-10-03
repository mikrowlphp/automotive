<?php

declare(strict_types=1);

use Packages\Automotive\Garage\Filament\Resources\CustomerResource\Pages\CreateCustomer;
use Packages\Automotive\Garage\Filament\Resources\CustomerResource\Pages\EditCustomer;
use Packages\Automotive\Garage\Filament\Resources\CustomerResource\Pages\ListCustomers;
use Packages\Automotive\Garage\Filament\Resources\MechanicsServiceResource\Pages\CreateMechanicsService;
use Packages\Automotive\Garage\Filament\Resources\MechanicsServiceResource\Pages\EditMechanicsService;
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

// =========================================================================
// PRICED LINES (shared by every service type)
// =========================================================================

describe('Service type forms - Lines', function () {
    it('fills the priced lines and totals them', function (string $page, \Packages\Automotive\Garage\Enums\ServiceType $type, array $parameters) {
        $record = \Packages\Automotive\Garage\Models\ServiceRecord::factory()->create(['type' => $type, 'parameters' => $parameters, 'total_amount' => 0]);

        $form = livewire($page, ['record' => $record->id]);
        $first = array_key_last($form->get('data.lines'));

        $form->set("data.lines.{$first}.description", 'Labour')
            ->set("data.lines.{$first}.quantity", 1.5)
            ->set("data.lines.{$first}.unit_price", 40);

        expect($form->get('data.lines'))->toHaveCount(2)
            ->and($form->get('data.total_amount'))->toEqual(60);

        $form->call('save')->assertHasNoFormErrors();

        expect((float) $record->fresh()->total_amount)->toEqual(60.0)
            ->and((float) $record->lines()->sole()->line_total)->toEqual(60.0);
    })->with([
        'mechanics'   => [\Packages\Automotive\Garage\Filament\Resources\MechanicsServiceResource\Pages\EditMechanicsService::class, \Packages\Automotive\Garage\Enums\ServiceType::Mechanics, []],
        'electrician' => [\Packages\Automotive\Garage\Filament\Resources\ElectricianServiceResource\Pages\EditElectricianService::class, \Packages\Automotive\Garage\Enums\ServiceType::Electrician, ['system_area' => 'lighting', 'service_type' => 'repair']],
        'bodywork'    => [\Packages\Automotive\Garage\Filament\Resources\BodyworkServiceResource\Pages\EditBodyworkService::class, \Packages\Automotive\Garage\Enums\ServiceType::Bodywork, []],
        'tires'       => [\Packages\Automotive\Garage\Filament\Resources\TireServiceResource\Pages\EditTireService::class, \Packages\Automotive\Garage\Enums\ServiceType::Tires, ['service_type' => 'rotation']],
    ])->group('resource', 'garage', 'service-lines', 'edit');
})->group('garage');

describe('Service parts - Lines', function () {
    it('fills a part line from the picked product', function () {
        $product = \Packages\Sales\Shared\Models\Product::factory()->create(['name' => 'Oil filter', 'selling_price' => 12.5]);
        $record = \Packages\Automotive\Garage\Models\ServiceRecord::factory()->create(['total_amount' => 0]);

        $form = livewire(EditMechanicsService::class, ['record' => $record->id]);
        $first = array_key_last($form->get('data.lines'));

        $form->set("data.lines.{$first}.product_id", $product->id)
            ->set("data.lines.{$first}.quantity", 2);

        $line = $form->get("data.lines.{$first}");

        expect($line['type'])->toBe('part')
            ->and($line['description'])->toBe('Oil filter')
            ->and((float) $line['unit_price'])->toEqual(12.5)
            ->and($form->get('data.lines'))->toHaveCount(2);

        $form->call('save')->assertHasNoFormErrors();

        expect((float) $record->fresh()->total_amount)->toEqual(25.0)
            ->and($record->lines()->sole()->product_id)->toBe($product->id);
    })->group('resource', 'garage', 'service-lines', 'edit');

    it('moves the parts of the parameters into part lines', function () {
        require_once base_path('packages/automotive/src/Garage/Database/Migrations/11_MovePartsToServiceRecordLines.php');
        $migration = new \Packages\Automotive\Garage\Database\Migrations\MovePartsToServiceRecordLines;
        $product = \Packages\Sales\Shared\Models\Product::factory()->create(['name' => 'Brake disc']);

        $mechanics = \Packages\Automotive\Garage\Models\ServiceRecord::factory()->create([
            'type' => \Packages\Automotive\Garage\Enums\ServiceType::Mechanics,
            'total_amount' => 150,
            'parameters' => [
                'work_type' => 'repair',
                'parts_replaced' => [['product_id' => $product->id, 'quantity' => 2, 'note' => 'Front axle']],
            ],
        ]);
        $bodywork = \Packages\Automotive\Garage\Models\ServiceRecord::factory()->create([
            'type' => \Packages\Automotive\Garage\Enums\ServiceType::Bodywork,
            'parameters' => ['parts_used' => [['product_id' => $product->id, 'quantity' => null, 'note' => null]]],
        ]);
        $untouched = \Packages\Automotive\Garage\Models\ServiceRecord::factory()->create(['parameters' => ['work_type' => 'check']]);

        $migration->up();

        $line = $mechanics->lines()->sole();

        expect($line->type)->toBe(\Packages\Automotive\Garage\Enums\ServiceLineType::Part)
            ->and($line->product_id)->toBe($product->id)
            ->and($line->description)->toBe('Brake disc - Front axle')
            ->and((float) $line->quantity)->toEqual(2.0)
            ->and((float) $line->unit_price)->toEqual(0.0)
            ->and($mechanics->fresh()->parameters)->toBe(['work_type' => 'repair'])
            ->and((float) $mechanics->fresh()->total_amount)->toEqual(150.0)
            ->and((float) $bodywork->lines()->sole()->quantity)->toEqual(1.0)
            ->and($bodywork->fresh()->parameters)->toBe([])
            ->and($untouched->lines()->count())->toBe(0);

        $migration->down();

        expect($mechanics->fresh()->parameters['parts_replaced'])->toEqual([['product_id' => $product->id, 'quantity' => 2, 'note' => null]])
            ->and($bodywork->fresh()->parameters['parts_used'][0]['product_id'])->toBe($product->id)
            ->and($mechanics->lines()->count())->toBe(0);
    })->group('garage', 'migrations');
})->group('garage');
