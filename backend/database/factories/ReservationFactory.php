<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $startDate = fake()->dateTimeBetween('now', '+10 days');
        $endDate = (clone $startDate)->modify('+' . fake()->numberBetween(1, 10) . ' days');

        $vehicle = Vehicle::query()->inRandomOrder()->first();
        $pricePerDay = $vehicle ? $vehicle->price_per_day : 50;
        $days = $startDate->diff($endDate)->days ?: 1;
        $totalPrice = $pricePerDay * $days;

        return [
            'user_id' => User::query()->inRandomOrder()->value('id'),
            'vehicle_id' => $vehicle?->id ?? Vehicle::factory(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_price' => $totalPrice,
        ];
    }
}
