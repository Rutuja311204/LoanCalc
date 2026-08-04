<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLoanStatus extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                  => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'loan_application_id' => ['type' => 'INT', 'unsigned' => true],
            'status'              => ['type' => 'ENUM', 'constraint' => ['pending', 'under_review', 'approved', 'rejected', 'disbursed']],
            'remarks'             => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'updated_by'          => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'created_at'          => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('loan_application_id');
        $this->forge->addForeignKey('loan_application_id', 'loan_applications', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('updated_by', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('loan_status');
    }

    public function down()
    {
        $this->forge->dropTable('loan_status');
    }
}
