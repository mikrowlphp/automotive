<?php

namespace Packages\Automotive\Garage\Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // CRITICAL: Seed permissions FIRST
        $this->call([
            PermissionSeeder::class,
        ]);

        // Seed car brands and models
        $this->call([
            CarBrandSeeder::class,
        ]);

        // Seed product categories for automotive parts
        $this->call([
            ProductCategorySeeder::class,
        ]);
    }
}
