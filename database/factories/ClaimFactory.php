<?php

namespace Database\Factories;

use App\Models\Beneficiary;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Claim>
 */
class ClaimFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'provider_id' => Provider::inRandomOrder()->first()->id ?? Provider::factory(),
            'beneficiary_id' => Beneficiary::inRandomOrder()->first()->id ?? Beneficiary::factory(),
            'date_of_service' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'visit_type' => $this->faker->randomElement(['OPD', 'IPD', 'Maternity', 'Referral']),
            'diagnoses' => ['General Consultation'],
            'status' => $this->faker->randomElement(['Draft', 'Submitted', 'UnderReview', 'Approved', 'Rejected', 'Paid']),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
