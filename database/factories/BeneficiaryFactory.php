<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Beneficiary>
 */
class BeneficiaryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nhis_number' => $this->faker->unique()->regexify('[A-Z0-9]{12}'),
            'full_name' => $this->faker->name(),
            'date_of_birth' => $this->faker->dateTimeBetween('-80 years', '-18 years'),
            'sex' => $this->faker->randomElement(['Male', 'Female', 'Other']),
            'scheme_type' => $this->faker->randomElement(['NHIS', 'Private']),
            'expiry_date' => $this->faker->dateTimeBetween('now', '+2 years'),
        ];
    }
}
