<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAdmin extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id'     => ['type' => 'INT', 'unsigned' => true],
            'designation' => ['type' => 'VARCHAR', 'constraint' => 100, 'default' => 'Loan Officer'],
            'permissions' => ['type' => 'VARCHAR', 'constraint' => 255, 'default' => 'all'],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('user_id');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('admin');
    }

    public function down()
    {
        $this->forge->dropTable('admin');
    }
}
