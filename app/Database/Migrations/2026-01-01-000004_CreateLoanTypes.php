<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLoanTypes extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                 => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'name'               => ['type' => 'VARCHAR', 'constraint' => 100],
            'slug'               => ['type' => 'VARCHAR', 'constraint' => 100],
            'description'        => ['type' => 'TEXT', 'null' => true],
            'min_amount'         => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 10000],
            'max_amount'         => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 5000000],
            'min_tenure_months'  => ['type' => 'INT', 'default' => 6],
            'max_tenure_months'  => ['type' => 'INT', 'default' => 360],
            'base_interest_rate' => ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 10.00],
            'icon'               => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'bi-cash-coin'],
            'status'             => ['type' => 'ENUM', 'constraint' => ['active', 'inactive'], 'default' => 'active'],
            'created_at'         => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('loan_types');
    }

    public function down()
    {
        $this->forge->dropTable('loan_types');
    }
}
