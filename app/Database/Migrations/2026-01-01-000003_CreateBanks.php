<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBanks extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                     => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'bank_name'              => ['type' => 'VARCHAR', 'constraint' => 150],
            'bank_code'              => ['type' => 'VARCHAR', 'constraint' => 20],
            'logo'                   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'interest_rate_min'      => ['type' => 'DECIMAL', 'constraint' => '5,2'],
            'interest_rate_max'      => ['type' => 'DECIMAL', 'constraint' => '5,2'],
            'processing_fee_percent' => ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 1.00],
            'status'                 => ['type' => 'ENUM', 'constraint' => ['active', 'inactive'], 'default' => 'active'],
            'created_at'             => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('bank_code');
        $this->forge->createTable('banks');
    }

    public function down()
    {
        $this->forge->dropTable('banks');
    }
}
