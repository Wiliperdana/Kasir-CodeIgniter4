<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\User;
use CodeIgniter\HTTP\ResponseInterface;

class MainController extends BaseController
{
    protected $produkModel;
    protected $userModel;
    protected $penjualanModel;

    public function __construct()
    {
        $this->produkModel = new Produk();
        $this->userModel = new User();
        $this->penjualanModel = new Penjualan();
    }

    public function dashboard()
    {
        $data = [
            'jumlahProduk' => $this->produkModel->countAll(),
            'jumlahUser' => $this->userModel->countAll(),
            'transaksi' => $this->penjualanModel->countAll(),
            'totalharga' => $this->penjualanModel->selectSum('TotalHarga')->get()->getRow()->TotalHarga
        ];
        
        return view('admin/dashboard', $data);
    }

}
