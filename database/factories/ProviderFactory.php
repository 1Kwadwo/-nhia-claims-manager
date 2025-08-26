<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Provider>
 */
class ProviderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $regions = ['Greater Accra', 'Ashanti', 'Western', 'Central', 'Eastern', 'Volta', 'Northern', 'Upper East', 'Upper West'];
        $hospitals = [
            'Legon Clinic',
            'Kumasi Hospital',
            'Tema General Hospital',
            'Korle Bu Teaching Hospital',
            'Komfo Anokye Teaching Hospital',
            'Ho Regional Hospital',
            'Cape Coast Regional Hospital',
            'Tamale Teaching Hospital',
            'Sunyani Regional Hospital',
            'Koforidua Regional Hospital'
        ];

        return [
            'name' => $this->faker->unique()->randomElement($hospitals),
            'nhis_code' => 'NHIS' . $this->faker->unique()->numberBetween(1000, 9999),
            'region' => $this->faker->randomElement($regions),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
        ];
    }
}
