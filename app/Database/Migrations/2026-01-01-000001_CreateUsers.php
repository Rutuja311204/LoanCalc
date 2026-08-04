<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'full_name'      => ['type' => 'VARCHAR', 'constraint' => 150],
            'email'          => ['type' => 'VARCHAR', 'constraint' => 150],
            'phone'          => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'password'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'role'           => ['type' => 'ENUM', 'constraint' => ['user', 'admin'], 'default' => 'user'],
            'address'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'dob'            => ['type' => 'DATE', 'null' => true],
            'profile_image'  => ['type' => 'VARCHAR', 'constraint' => 255, 'default' => 'default.png'],
            'reset_token'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'reset_expires'  => ['type' => 'DATETIME', 'null' => true],
            'status'         => ['type' => 'ENUM', 'constraint' => ['active', 'inactive'], 'default' => 'active'],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email');
        $this->forge->addKey('role');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
