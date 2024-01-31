<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
    public function up()
    {
        // structure
        $this->forge->addField([
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'password' => [
                'type' => 'TEXT',
            ],
            'role' => [
                'type' => 'ENUM("admin", "kasir")',
            ],
        ]);

        // primary key
        $this->forge->addKey('id_user', true);

        // create table
        $this->forge->createTable('user');
    }

    public function down()
    {
        // drop table
        $this->forge->dropTable('user');
    }
}
