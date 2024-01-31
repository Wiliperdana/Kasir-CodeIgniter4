<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Penjualan extends Migration
{
    public function up()
    {
        // structure
        $this->forge->addField([
            'PenjualanID' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'TanggalPenjualan' => [
                'type' => 'DATE',
            ],
            'TotalHarga' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2'
            ],
            'PelangganID' => [
                'type' => 'INT',
                'constraint' => 11
            ]
        ]);

        // primary key
        $this->forge->addKey('PenjualanID', true);

        // foreign key
        $this->forge->addForeignKey('PelangganID', 'pelanggan', 'PelangganID');

        // create table
        $this->forge->createTable('penjualan');
    }

    public function down()
    {
        // drop table
        $this->forge->dropTable('pelanggan');
    }
}
