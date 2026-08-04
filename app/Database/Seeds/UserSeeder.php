<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $hash = password_hash('Password@123', PASSWORD_BCRYPT);

        $data = [
            [
                'full_name'  => 'System Administrator',
                'email'      => 'admin@loancalc.test',
                'phone'      => '9999999999',
                'password'   => $hash,
                'role'       => 'admin',
                'address'    => 'Head Office, Mumbai',
                'status'     => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'full_name'  => 'Rahul Sharma',
                'email'      => 'rahul.sharma@example.com',
                'phone'      => '9876543210',
                'password'   => $hash,
                'role'       => 'user',
                'address'    => 'Pune, Maharashtra',
                'status'     => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'full_name'  => 'Priya Patel',
                'email'      => 'priya.patel@example.com',
                'phone'      => '9876500011',
                'password'   => $hash,
                'role'       => 'user',
                'address'    => 'Ahmedabad, Gujarat',
                'status'     => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($data);

        $adminId = $this->db->table('users')->where('email', 'admin@loancalc.test')->get()->getRow()->id;
        $this->db->table('admin')->insert([
            'user_id'     => $adminId,
            'designation' => 'Chief Loan Officer',
            'permissions' => 'all',
            'created_at'  => date('Y-m-d H:i:s'),
        ]);
    }
}
