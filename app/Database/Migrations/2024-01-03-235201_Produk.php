<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Produk extends Migration
{
    public function up()
    {
        // structure
        $this->forge->addField([
            'ProdukID' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'NamaProduk' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'Harga' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2'
            ],
            'Stok' => [
                'type' => 'INT',
                'constraint' => 11
            ]
        ]);

        // primary key
        $this->forge->addKey('ProdukID', true);

        // create table
        $this->forge->createTable('produk');
    }

    public function down()
    {
        // drop table
        $this->forge->dropTable('produk');
    }
}
