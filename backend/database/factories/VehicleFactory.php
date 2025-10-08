<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'brand' => fake()->company(),
            'model' => fake()->word(),
            'plate_number' => strtoupper(fake()->bothify('??-####')),
            'year' => fake()->numberBetween(2010, 2025),
            'price_per_day' => fake()->numberBetween(30, 150),
            'fuel_type' => fake()->randomElement(['petrol', 'diesel', 'hybrid', 'electric']),
            'transmission' => fake()->randomElement(['manual', 'automatic']),
            'seats' => fake()->numberBetween(2, 7),
            'tank_capacity' => fake()->numberBetween(30, 80),
            'available' => true,
        ];
    }
}
