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
                'seeder' => Garage\Database\Seeders\DatabaseSeeder::class,
                'dependencies' => [
                    'inventory',
                ],
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
