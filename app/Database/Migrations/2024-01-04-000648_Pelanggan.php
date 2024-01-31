<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pelanggan extends Migration
{
    public function up()
    {
        // structure
        $this->forge->addField([
            'PelangganID' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'NamaPelanggan' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'Alamat' => [
                'type' => 'TEXT'
            ],
            'NomorTelepon' => [
                'type' => 'VARCHAR',
                'constraint' => '15'
            ]
        ]);

        // primary key
        $this->forge->addKey('PelangganID', true);

        // create table
        $this->forge->createTable('pelanggan');
    }

    public function down()
    {
        // drop table
        $this->forge->dropTable('pelanggan');
    }
}
