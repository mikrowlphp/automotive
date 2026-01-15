<?php

namespace Packages\Automotive\Garage\Database\Seeders;

use Illuminate\Database\Seeder;
use Packages\Automotive\Garage\Models\CarBrand;
use Packages\Automotive\Garage\Models\CarModel;
use Packages\Automotive\Garage\Models\CarVariant;

class CarBrandSeeder extends Seeder
{
    /**
     * Data files to load (in order)
     */
    protected array $dataFiles = [
        'ItalianBrands',
        'GermanBrands',
        'FrenchBrands',
        'JapaneseBrands',
        'KoreanBrands',
        'AmericanBrands',
        'OtherEuropeanBrands',
    ];

    /**
     * Counters for statistics
     */
    protected int $totalBrands = 0;

    protected int $totalModels = 0;

    protected int $totalVariants = 0;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🚗 Seeding car brands, models, and variants...');
        $this->command->newLine();

        foreach ($this->dataFiles as $dataFile) {
            $this->seedDataFile($dataFile);
        }

        $this->command->newLine();
        $this->command->info('✅ Seeding completed!');
        $this->command->info("   📊 {$this->totalBrands} brands");
        $this->command->info("   📊 {$this->totalModels} models");
        $this->command->info("   📊 {$this->totalVariants} variants");
    }

    /**
     * Seed a single data file
     */
    protected function seedDataFile(string $dataFile): void
    {
        $path = __DIR__."/Data/{$dataFile}.php";

        if (! file_exists($path)) {
            $this->command->warn("⚠️  Data file not found: {$dataFile}.php");

            return;
        }

        $brands = require $path;
        $fileModels = 0;
        $fileVariants = 0;

        foreach ($brands as $brandData) {
            $result = $this->seedBrand($brandData);
            $fileModels += $result['models'];
            $fileVariants += $result['variants'];
        }

        $brandCount = count($brands);
        $this->command->line("   ✓ {$dataFile}: {$brandCount} brands, {$fileModels} models, {$fileVariants} variants");

        $this->totalBrands += $brandCount;
        $this->totalModels += $fileModels;
        $this->totalVariants += $fileVariants;
    }

    /**
     * Seed a single brand with its models and variants
     */
    protected function seedBrand(array $brandData): array
    {
        $models = $brandData['models'] ?? [];
        unset($brandData['models']);

        // Create or update the brand
        $brand = CarBrand::updateOrCreate(
            ['name' => $brandData['name']],
            array_merge($brandData, ['is_active' => true])
        );

        $modelCount = 0;
        $variantCount = 0;

        foreach ($models as $modelData) {
            $result = $this->seedModel($brand, $modelData);
            $modelCount++;
            $variantCount += $result;
        }

        return ['models' => $modelCount, 'variants' => $variantCount];
    }

    /**
     * Seed a single model with its variants
     */
    protected function seedModel(CarBrand $brand, array $modelData): int
    {
        $variants = $modelData['variants'] ?? [];
        $bodyType = $modelData['body_type'] ?? null;
        unset($modelData['variants'], $modelData['body_type']);

        // Create or update the model
        $model = CarModel::updateOrCreate(
            [
                'car_brand_id' => $brand->id,
                'name' => $modelData['name'],
            ],
            array_merge($modelData, ['is_active' => true])
        );

        $variantCount = 0;

        foreach ($variants as $variantData) {
            $this->seedVariant($model, $variantData, $bodyType);
            $variantCount++;
        }

        return $variantCount;
    }

    /**
     * Seed a single variant
     */
    protected function seedVariant(CarModel $model, array $variantData, ?string $defaultBodyType): void
    {
        // Use variant body_type or fall back to model's default
        if (! isset($variantData['body_type']) && $defaultBodyType) {
            $variantData['body_type'] = $defaultBodyType;
        }

        CarVariant::updateOrCreate(
            [
                'car_model_id' => $model->id,
                'name' => $variantData['name'],
            ],
            array_merge($variantData, ['is_active' => true])
        );
    }

    /**
     * Clean up all seeded data
     */
    public static function cleanup(): void
    {
        CarVariant::query()->delete();
        CarModel::query()->delete();
        CarBrand::query()->delete();
    }
}
