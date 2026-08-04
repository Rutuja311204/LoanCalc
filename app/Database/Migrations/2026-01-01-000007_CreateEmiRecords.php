<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmiRecords extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                  => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id'             => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'loan_application_id' => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'principal'           => ['type' => 'DECIMAL', 'constraint' => '15,2'],
            'interest_rate'       => ['type' => 'DECIMAL', 'constraint' => '5,2'],
            'tenure_months'       => ['type' => 'INT'],
            'emi_amount'          => ['type' => 'DECIMAL', 'constraint' => '15,2'],
            'total_interest'      => ['type' => 'DECIMAL', 'constraint' => '15,2'],
            'total_payment'       => ['type' => 'DECIMAL', 'constraint' => '15,2'],
            'schedule_json'       => ['type' => 'LONGTEXT', 'null' => true],
            'created_at'          => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('loan_application_id', 'loan_applications', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('emi_records');
    }

    public function down()
    {
        $this->forge->dropTable('emi_records');
    }
}
