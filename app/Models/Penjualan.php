<?php

namespace App\Models;

use CodeIgniter\Model;

class Penjualan extends Model
{
    protected $table            = 'penjualan';
    protected $primaryKey       = 'PenjualanID';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['TanggalPenjualan', 'TotalHarga', 'PelangganID'];
}
