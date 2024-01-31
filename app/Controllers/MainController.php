<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Produk;
use App\Models\User;
use CodeIgniter\HTTP\ResponseInterface;

class MainController extends BaseController
{
    protected $produkModel;
    protected $userModel;

    public function __construct()
    {
        $this->produkModel = new Produk();
        $this->userModel = new User();
    }

    public function dashboard()
    {
        $jumlahProduk = $this->produkModel->countAll();
        $jumlahUser = $this->userModel->countAll();
        $data['jumlahProduk'] = $jumlahProduk;
        $data['jumlahUser'] = $jumlahUser;
        
        return view('admin/dashboard', $data);
    }
}
