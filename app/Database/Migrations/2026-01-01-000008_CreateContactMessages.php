<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateContactMessages extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'name'       => ['type' => 'VARCHAR', 'constraint' => 150],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 150],
            'phone'      => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'subject'    => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'message'    => ['type' => 'TEXT'],
            'is_read'    => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('is_read');
        $this->forge->createTable('contact_messages');
    }

    public function down()
    {
        $this->forge->dropTable('contact_messages');
    }
}
