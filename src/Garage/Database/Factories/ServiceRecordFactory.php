<?php

namespace Packages\Automotive\Garage\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Packages\Automotive\Garage\Enums\ServiceRecordStatus;
use Packages\Automotive\Garage\Enums\ServiceType;
use Packages\Automotive\Garage\Models\ServiceRecord;
use Packages\Automotive\Garage\Models\Vehicle;

class ServiceRecordFactory extends Factory
{
    protected $model = ServiceRecord::class;

    public function definition(): array
    {
        $vehicle = Vehicle::factory()->create();

        return [
            'vehicle_id'          => $vehicle->id,
            'customer_id'         => $vehicle->customer_id,
            'diagnosis_id'        => null,
            'service_date'        => fake()->dateTimeBetween('-3 months', 'now'),
            'mileage_at_service'  => fake()->numberBetween(0, 200000),
            'status'              => ServiceRecordStatus::Draft,
            'type'                => ServiceType::Mechanics,
            'parameters'          => [],
            'notes'               => fake()->optional()->sentence(),
            'total_amount'        => fake()->randomFloat(2, 50, 2000),
        ];
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ServiceRecordStatus::Completed,
        ]);
    }

    public function inProgress(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ServiceRecordStatus::InProgress,
        ]);
    }
}
