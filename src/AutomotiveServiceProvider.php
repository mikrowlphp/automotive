<?php

namespace Packages\Automotive;

use App\PackageServiceProvider;
use Packages\Automotive\Garage\Models\CarBrand;
use Packages\Automotive\Garage\Models\CarModel;
use Packages\Automotive\Garage\Models\Diagnosis;
use Packages\Automotive\Garage\Models\ServiceRecord;
use Packages\Automotive\Garage\Models\Vehicle;
use Packages\Automotive\Garage\Policies\CarBrandPolicy;
use Packages\Automotive\Garage\Policies\CarModelPolicy;
use Packages\Automotive\Garage\Policies\DiagnosisPolicy;
use Packages\Automotive\Garage\Policies\ServiceRecordPolicy;
use Packages\Automotive\Garage\Policies\VehiclePolicy;

class AutomotiveServiceProvider extends PackageServiceProvider
{
    public function getPackageName(): string
    {
        return 'automotive';
    }

    public function boot(): void
    {
        parent::boot();

        // Lazy-register the Customer->vehicles relation so that the sales package
        // does not need to import any automotive class. This runs only when the
        // automotive package is actually loaded.
        if (class_exists(\Packages\Sales\Shared\Models\Customer::class)) {
            \Packages\Sales\Shared\Models\Customer::resolveRelationUsing(
                'vehicles',
                fn ($model) => $model->hasMany(Vehicle::class, 'customer_id')
            );
        }
    }

    public function registerModules(): void
    {
        $this->modules = [
            [
                'name_key' => 'automotive::modules.garage.name',
                'slug' => 'garage',
                'description_key' => 'automotive::modules.garage.description',
                'panels' => [
                    'Garage\\GaragePanelProvider',
                ],
                'seeder' => 'Garage\\Database\\Seeders\\DatabaseSeeder',
                'dependencies' => [
                    'sales', // inventory module is part of the sales package
                ],
                'installs' => [],
                'protected' => false,
            ],
        ];
    }

    protected function policies(): array
    {
        return [
            CarBrand::class => CarBrandPolicy::class,
            CarModel::class => CarModelPolicy::class,
            Vehicle::class => VehiclePolicy::class,
            ServiceRecord::class => ServiceRecordPolicy::class,
            Diagnosis::class => DiagnosisPolicy::class,
        ];
    }
}
