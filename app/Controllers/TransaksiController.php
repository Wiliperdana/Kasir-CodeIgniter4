<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Produk;
use CodeIgniter\HTTP\ResponseInterface;

class TransaksiController extends BaseController
{
    protected $produkModel;

    public function __construct()
    {
        $this->produkModel = new Produk();
    }

    public function index()
    {
        $data['menuProduk'] = $this->produkModel->findAll();

        return view('admin/transaksi', $data);
    }
}
