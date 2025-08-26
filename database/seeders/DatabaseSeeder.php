<?php

namespace Database\Seeders;

use App\Models\Beneficiary;
use App\Models\Claim;
use App\Models\ClaimItem;
use App\Models\Provider;
use App\Models\Tariff;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create demo users if they don't exist
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
            ]);
        }

        if (!User::where('email', 'user@example.com')->exists()) {
            User::create([
                'name' => 'Regular User',
                'email' => 'user@example.com',
                'password' => Hash::make('password'),
            ]);
        }

        // Create providers if they don't exist
        if (Provider::count() === 0) {
            $providers = collect([
                Provider::create([
                    'name' => 'Legon Clinic',
                    'nhis_code' => 'NHIS1001',
                    'region' => 'Greater Accra',
                    'phone' => '+233 20 123 4567',
                    'address' => 'University of Ghana, Legon',
                ]),
                Provider::create([
                    'name' => 'Kumasi Hospital',
                    'nhis_code' => 'NHIS1002',
                    'region' => 'Ashanti',
                    'phone' => '+233 32 234 5678',
                    'address' => 'Kumasi Central, Ashanti Region',
                ]),
                Provider::create([
                    'name' => 'Tema General Hospital',
                    'nhis_code' => 'NHIS1003',
                    'region' => 'Greater Accra',
                    'phone' => '+233 30 345 6789',
                    'address' => 'Tema Industrial Area',
                ]),
            ]);
        } else {
            $providers = Provider::all();
        }

        // Create beneficiaries if they don't exist
        if (Beneficiary::count() === 0) {
            $beneficiaries = collect([
                Beneficiary::create([
                    'nhis_number' => 'NHIS123456789',
                    'full_name' => 'John Doe',
                    'date_of_birth' => '1985-05-15',
                    'sex' => 'Male',
                    'scheme_type' => 'NHIS',
                    'expiry_date' => '2025-12-31',
                ]),
                Beneficiary::create([
                    'nhis_number' => 'NHIS987654321',
                    'full_name' => 'Jane Smith',
                    'date_of_birth' => '1990-08-22',
                    'sex' => 'Female',
                    'scheme_type' => 'NHIS',
                    'expiry_date' => '2025-12-31',
                ]),
                Beneficiary::create([
                    'nhis_number' => 'NHIS456789123',
                    'full_name' => 'Kwame Asante',
                    'date_of_birth' => '1978-12-10',
                    'sex' => 'Male',
                    'scheme_type' => 'Private',
                    'expiry_date' => '2025-12-31',
                ]),
            ]);
        } else {
            $beneficiaries = Beneficiary::all();
        }

        // Create tariffs if they don't exist
        if (Tariff::count() === 0) {
            $tariffData = [
                ['CON001', 'General Consultation', 'Consultation', 100],
                ['CON002', 'Specialist Consultation', 'Consultation', 150],
                ['LAB001', 'Blood Test - Complete Blood Count', 'Lab', 50],
                ['LAB002', 'Blood Test - Blood Sugar', 'Lab', 30],
                ['DRG001', 'Paracetamol 500mg', 'Drug', 5],
                ['DRG002', 'Amoxicillin 500mg', 'Drug', 15],
                ['PRO001', 'Minor Surgery', 'Procedure', 500],
                ['PRO002', 'Dental Extraction', 'Procedure', 200],
            ];

            $tariffs = collect();
            foreach ($tariffData as $data) {
                $tariffs->push(Tariff::create([
                    'service_code' => $data[0],
                    'description' => $data[1],
                    'category' => $data[2],
                    'unit_price' => $data[3],
                    'effective_date' => now()->subDays(rand(1, 365)),
                ]));
            }
        } else {
            $tariffs = Tariff::all();
        }

        // Create claims if they don't exist
        if (Claim::count() === 0) {
            $visitTypes = ['OPD', 'IPD', 'Maternity', 'Referral'];
            $statuses = ['Draft', 'Submitted', 'UnderReview', 'Approved', 'Rejected', 'Paid'];
            
            for ($i = 0; $i < 5; $i++) {
                $claim = Claim::create([
                    'provider_id' => $providers->random()->id,
                    'beneficiary_id' => $beneficiaries->random()->id,
                    'date_of_service' => now()->subDays(rand(1, 180)),
                    'visit_type' => $visitTypes[array_rand($visitTypes)],
                    'diagnoses' => ['General Consultation'],
                    'status' => $statuses[array_rand($statuses)],
                    'notes' => 'Demo claim for testing',
                ]);

                // Create 2 items per claim
                for ($j = 0; $j < 2; $j++) {
                    $tariff = $tariffs->random();
                    ClaimItem::create([
                        'claim_id' => $claim->id,
                        'service_code' => $tariff->service_code,
                        'description' => $tariff->description,
                        'category' => $tariff->category,
                        'quantity' => rand(1, 3),
                        'unit_price' => $tariff->unit_price,
                    ]);
                }
            }
        }
    }
}
