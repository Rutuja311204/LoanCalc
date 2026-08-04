<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmailLogs extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'to_email'     => ['type' => 'VARCHAR', 'constraint' => 150],
            'subject'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'body'         => ['type' => 'TEXT', 'null' => true],
            'status'       => ['type' => 'ENUM', 'constraint' => ['sent', 'failed'], 'default' => 'sent'],
            'related_type' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'related_id'   => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('to_email');
        $this->forge->createTable('email_logs');
    }

    public function down()
    {
        $this->forge->dropTable('email_logs');
    }
}
