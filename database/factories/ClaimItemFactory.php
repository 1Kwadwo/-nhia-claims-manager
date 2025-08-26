<?php

namespace Database\Factories;

use App\Models\Claim;
use App\Models\Tariff;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClaimItem>
 */
class ClaimItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tariff = Tariff::inRandomOrder()->first();
        
        if (!$tariff) {
            $tariff = Tariff::factory()->create();
        }

        $quantity = $this->faker->numberBetween(1, 5);
        $unitPrice = $tariff->unit_price;

        return [
            'claim_id' => Claim::inRandomOrder()->first()->id ?? Claim::factory(),
            'service_code' => $tariff->service_code,
            'description' => $tariff->description,
            'category' => $tariff->category,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'amount' => $quantity * $unitPrice,
        ];
    }
}
