<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLoanApplications extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'application_no'  => ['type' => 'VARCHAR', 'constraint' => 30],
            'user_id'         => ['type' => 'INT', 'unsigned' => true],
            'loan_type_id'    => ['type' => 'INT', 'unsigned' => true],
            'bank_id'         => ['type' => 'INT', 'unsigned' => true],
            'loan_amount'     => ['type' => 'DECIMAL', 'constraint' => '15,2'],
            'tenure_months'   => ['type' => 'INT'],
            'interest_rate'   => ['type' => 'DECIMAL', 'constraint' => '5,2'],
            'monthly_income'  => ['type' => 'DECIMAL', 'constraint' => '15,2', 'null' => true],
            'employment_type' => ['type' => 'ENUM', 'constraint' => ['salaried', 'self_employed', 'business', 'other'], 'default' => 'salaried'],
            'purpose'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'emi_amount'      => ['type' => 'DECIMAL', 'constraint' => '15,2', 'null' => true],
            'total_payable'   => ['type' => 'DECIMAL', 'constraint' => '15,2', 'null' => true],
            'total_interest'  => ['type' => 'DECIMAL', 'constraint' => '15,2', 'null' => true],
            'documents'       => ['type' => 'TEXT', 'null' => true],
            'current_status'  => ['type' => 'ENUM', 'constraint' => ['pending', 'under_review', 'approved', 'rejected', 'disbursed'], 'default' => 'pending'],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('application_no');
        $this->forge->addKey('user_id');
        $this->forge->addKey('current_status');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('loan_type_id', 'loan_types', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('bank_id', 'banks', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('loan_applications');
    }

    public function down()
    {
        $this->forge->dropTable('loan_applications');
    }
}
