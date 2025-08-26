<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tariff>
 */
class TariffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $consultations = [
            'CON001' => 'General Consultation',
            'CON002' => 'Specialist Consultation',
            'CON003' => 'Emergency Consultation',
            'CON004' => 'Follow-up Consultation',
            'CON005' => 'Pediatric Consultation',
        ];

        $labs = [
            'LAB001' => 'Blood Test - Complete Blood Count',
            'LAB002' => 'Blood Test - Blood Sugar',
            'LAB003' => 'Urine Analysis',
            'LAB004' => 'X-Ray - Chest',
            'LAB005' => 'X-Ray - Limb',
            'LAB006' => 'Ultrasound - Abdominal',
            'LAB007' => 'ECG',
            'LAB008' => 'HIV Test',
            'LAB009' => 'Malaria Test',
            'LAB010' => 'Pregnancy Test',
        ];

        $drugs = [
            'DRG001' => 'Paracetamol 500mg',
            'DRG002' => 'Amoxicillin 500mg',
            'DRG003' => 'Ibuprofen 400mg',
            'DRG004' => 'Omeprazole 20mg',
            'DRG005' => 'Metformin 500mg',
            'DRG006' => 'Amlodipine 5mg',
            'DRG007' => 'Losartan 50mg',
            'DRG008' => 'Atorvastatin 20mg',
            'DRG009' => 'Vitamin C 1000mg',
            'DRG010' => 'Iron Supplements',
        ];

        $procedures = [
            'PRO001' => 'Minor Surgery',
            'PRO002' => 'Dental Extraction',
            'PRO003' => 'Suturing',
            'PRO004' => 'Injection',
            'PRO005' => 'Dressing',
            'PRO006' => 'Catheterization',
            'PRO007' => 'Endoscopy',
            'PRO008' => 'Biopsy',
            'PRO009' => 'Physiotherapy Session',
            'PRO010' => 'Laboratory Sample Collection',
        ];

        $allServices = array_merge($consultations, $labs, $drugs, $procedures);
        $serviceCodes = array_keys($allServices);
        $serviceCode = $serviceCodes[$this->faker->numberBetween(0, count($serviceCodes) - 1)];
        $description = $allServices[$serviceCode];

        $category = match (substr($serviceCode, 0, 3)) {
            'CON' => 'Consultation',
            'LAB' => 'Lab',
            'DRG' => 'Drug',
            'PRO' => 'Procedure',
            default => 'Other',
        };

        $unitPrice = match ($category) {
            'Consultation' => $this->faker->numberBetween(50, 200),
            'Lab' => $this->faker->numberBetween(30, 500),
            'Drug' => $this->faker->numberBetween(5, 100),
            'Procedure' => $this->faker->numberBetween(100, 1000),
            default => $this->faker->numberBetween(20, 200),
        };

        return [
            'service_code' => $serviceCode,
            'description' => $description,
            'category' => $category,
            'unit_price' => $unitPrice,
            'effective_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
