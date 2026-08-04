<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BankSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['bank_name' => 'HDFC Bank', 'bank_code' => 'HDFC', 'interest_rate_min' => 8.50, 'interest_rate_max' => 14.00, 'processing_fee_percent' => 1.00, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s')],
            ['bank_name' => 'ICICI Bank', 'bank_code' => 'ICICI', 'interest_rate_min' => 8.75, 'interest_rate_max' => 14.50, 'processing_fee_percent' => 1.00, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s')],
            ['bank_name' => 'State Bank of India', 'bank_code' => 'SBI', 'interest_rate_min' => 8.40, 'interest_rate_max' => 13.50, 'processing_fee_percent' => 0.75, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s')],
            ['bank_name' => 'Axis Bank', 'bank_code' => 'AXIS', 'interest_rate_min' => 8.90, 'interest_rate_max' => 15.00, 'processing_fee_percent' => 1.25, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s')],
            ['bank_name' => 'Kotak Mahindra Bank', 'bank_code' => 'KOTAK', 'interest_rate_min' => 9.00, 'interest_rate_max' => 15.50, 'processing_fee_percent' => 1.00, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s')],
        ];

        $this->db->table('banks')->insertBatch($data);
    }
}
