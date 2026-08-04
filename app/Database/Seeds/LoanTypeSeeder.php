<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LoanTypeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Home Loan', 'slug' => 'home-loan', 'description' => 'Finance your dream home with attractive interest rates.', 'min_amount' => 100000, 'max_amount' => 10000000, 'min_tenure_months' => 60, 'max_tenure_months' => 360, 'base_interest_rate' => 8.50, 'icon' => 'bi-house-door', 'status' => 'active', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Personal Loan', 'slug' => 'personal-loan', 'description' => 'Quick unsecured loans for personal needs.', 'min_amount' => 10000, 'max_amount' => 2000000, 'min_tenure_months' => 6, 'max_tenure_months' => 60, 'base_interest_rate' => 11.50, 'icon' => 'bi-person-badge', 'status' => 'active', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Car Loan', 'slug' => 'car-loan', 'description' => 'Drive home your favorite car with easy EMIs.', 'min_amount' => 50000, 'max_amount' => 3000000, 'min_tenure_months' => 12, 'max_tenure_months' => 84, 'base_interest_rate' => 9.25, 'icon' => 'bi-car-front', 'status' => 'active', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Education Loan', 'slug' => 'education-loan', 'description' => 'Fund your higher education aspirations.', 'min_amount' => 50000, 'max_amount' => 4000000, 'min_tenure_months' => 12, 'max_tenure_months' => 180, 'base_interest_rate' => 9.75, 'icon' => 'bi-mortarboard', 'status' => 'active', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Business Loan', 'slug' => 'business-loan', 'description' => 'Grow your business with flexible financing.', 'min_amount' => 100000, 'max_amount' => 5000000, 'min_tenure_months' => 12, 'max_tenure_months' => 120, 'base_interest_rate' => 12.00, 'icon' => 'bi-briefcase', 'status' => 'active', 'created_at' => date('Y-m-d H:i:s')],
        ];

        $this->db->table('loan_types')->insertBatch($data);
    }
}
