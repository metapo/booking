<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\calendar>
 */
class CalendarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $basePrice = fake()->numberBetween(5_000_000, 100_000_000);
        $adultPrice = intval($basePrice * 0.25);
        $childPrice = intval($basePrice * 0.15);
        $infantPrice = intval($basePrice * 0.1);

        return [
            'date' => Carbon::now()->addDay(),
            'base_price' => $basePrice,
            'adult_price' => $adultPrice,
            'child_price' => $childPrice,
            'infant_price' => $infantPrice,
            'is_reserved' => fake()->randomFloat(2, 0, 1) <= 0.8, //true for 80 percent of times
        ];
    }

}
