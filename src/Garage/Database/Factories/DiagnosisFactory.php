<?php

namespace Packages\Automotive\Garage\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Packages\Automotive\Garage\Enums\DiagnosisStatus;
use Packages\Automotive\Garage\Models\Diagnosis;
use Packages\Automotive\Garage\Models\Vehicle;

class DiagnosisFactory extends Factory
{
    protected $model = Diagnosis::class;

    public function definition(): array
    {
        $vehicle = Vehicle::factory()->create();

        return [
            'vehicle_id'             => $vehicle->id,
            'customer_id'            => $vehicle->customer_id,
            'acceptance_date'        => fake()->dateTimeBetween('-1 month', 'now'),
            'mileage_at_acceptance'  => fake()->numberBetween(0, 200000),
            'customer_complaint'     => fake()->sentence(),
            'initial_diagnosis'      => fake()->optional()->sentence(),
            'status'                 => DiagnosisStatus::Open,
            'notes'                  => fake()->optional()->sentence(),
        ];
    }

    public function closed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => DiagnosisStatus::Closed,
        ]);
    }
}
