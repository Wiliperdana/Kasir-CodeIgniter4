<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPenjualan extends Model
{
    protected $table            = 'detailpenjualan';
    protected $primaryKey       = 'DetailID';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['PenjualanID', 'ProdukID', 'JumlahProduk', 'Subtotal'];
}
