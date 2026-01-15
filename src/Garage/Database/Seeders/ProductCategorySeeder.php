<?php

namespace Packages\Automotive\Garage\Database\Seeders;

use Illuminate\Database\Seeder;
use Packages\Sales\Shared\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    /**
     * Product categories for the Automotive Services module.
     * These categories are used to organize spare parts and products.
     */
    public function run(): void
    {
        // Create parent category for all automotive parts
        $automotive = ProductCategory::firstOrCreate(
            ['slug' => 'ricambi-automotive'],
            [
                'name' => 'Ricambi Automotive',
                'description' => 'Ricambi e prodotti per officina automotive',
                'status' => 'active',
            ]
        );

        // Tires category
        ProductCategory::firstOrCreate(
            ['slug' => 'pneumatici'],
            [
                'name' => 'Pneumatici',
                'description' => 'Pneumatici per auto, moto e veicoli commerciali',
                'parent_category_id' => $automotive->id,
                'status' => 'active',
            ]
        );

        // Bodywork parts category
        ProductCategory::firstOrCreate(
            ['slug' => 'carrozzeria'],
            [
                'name' => 'Ricambi Carrozzeria',
                'description' => 'Parti di carrozzeria, paraurti, specchietti, fanali',
                'parent_category_id' => $automotive->id,
                'status' => 'active',
            ]
        );

        // Mechanics parts category
        ProductCategory::firstOrCreate(
            ['slug' => 'meccanica'],
            [
                'name' => 'Ricambi Meccanica',
                'description' => 'Parti meccaniche, filtri, freni, sospensioni',
                'parent_category_id' => $automotive->id,
                'status' => 'active',
            ]
        );

        // Electrician parts category
        ProductCategory::firstOrCreate(
            ['slug' => 'elettrauto'],
            [
                'name' => 'Ricambi Elettrauto',
                'description' => 'Componenti elettrici, batterie, alternatori, motorini',
                'parent_category_id' => $automotive->id,
                'status' => 'active',
            ]
        );
    }
}
