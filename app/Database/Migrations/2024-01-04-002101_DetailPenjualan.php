<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailPenjualan extends Migration
{
    public function up()
    {
        // structure
        $this->forge->addField([
            'DetailID' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'PenjualanID' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'ProdukID' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'JumlahProduk' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'Subtotal' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2'
            ]
        ]);

        // primary key
        $this->forge->addKey('DetailID', true);

        // foreign key
        $this->forge->addForeignKey('PenjualanID', 'penjualan', 'PenjualanID');
        $this->forge->addForeignKey('ProdukID', 'produk', 'ProdukID');

        // create table
        $this->forge->createTable('detailpenjualan');
    }

    public function down()
    {
        // drop table
        $this->forge->dropTable('detailpenjualan');
    }
}
