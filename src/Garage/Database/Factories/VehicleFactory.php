<?php

namespace Packages\Automotive\Garage\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Packages\Automotive\Garage\Models\CarBrand;
use Packages\Automotive\Garage\Models\CarModel;
use Packages\Automotive\Garage\Models\Vehicle;
use Packages\Core\Shared\Models\Contact;

class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;

    public function definition(): array
    {
        $brand = CarBrand::firstOrCreate(['name' => 'Test Brand'], ['is_active' => true]);
        $carModel = CarModel::firstOrCreate(
            ['name' => 'Test Model', 'car_brand_id' => $brand->id],
            ['is_active' => true]
        );

        return [
            'customer_id'  => Contact::factory(),
            'car_model_id' => $carModel->id,
            'license_plate' => strtoupper(fake()->unique()->bothify('??###??')),
            'vin'          => fake()->optional()->bothify('?????????????????'),
            'color'        => fake()->colorName(),
            'year'         => fake()->numberBetween(2000, 2024),
            'mileage'      => fake()->numberBetween(0, 200000),
            'fuel_type'    => fake()->randomElement(['gasoline', 'diesel', 'hybrid', 'electric']),
            'engine'       => fake()->optional()->bothify('1.?L ###hp'),
            'notes'        => fake()->optional()->sentence(),
            'is_active'    => true,
        ];
    }
}
