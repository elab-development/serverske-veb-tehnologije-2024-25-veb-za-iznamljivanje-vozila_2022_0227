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
            'year' => (int) fake()->numberBetween(2010, 2025),
            'price_per_day' => fake()->randomFloat(2, 20, 150),
            'available' => true,
            'vehicle_type' => fake()->randomElement(['hatchback','suv','sport','sedan']),
            'fuel_type' => fake()->randomElement(['petrol','diesel','hybrid','electric']),
            'transmission' => fake()->randomElement(['manual','automatic']),
            'seats' => fake()->numberBetween(2, 9),
            'tank_capacity' => fake()->numberBetween(30, 80),
        ];
    }
}
