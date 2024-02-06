<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DetailPenjualan;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\Produk;
use CodeIgniter\HTTP\ResponseInterface;

class TransaksiController extends BaseController
{
    protected $produkModel;
    protected $penjualanModel;
    protected $pelangganModel;
    protected $detailModel;

    public function __construct()
    {
        $this->produkModel = new Produk();
        $this->penjualanModel = new Penjualan();
        $this->pelangganModel = new Pelanggan();
        $this->detailModel = new DetailPenjualan();
    }

    public function index()
    {
        $data['menuProduk'] = $this->produkModel->findAll();
        $data['pelanggan'] = $this->pelangganModel->findAll();

        return view('admin/transaksi', $data);
    }

    public function store()
    {
        // Ambil data dari POST request atau sesuaikan sesuai kebutuhan
        $data = [
            'TanggalPenjualan' => $this->request->getPost('tglpenjualan'),
            'TotalHarga' => $this->request->getPost('total'),
            'PelangganID' => $this->request->getPost('pelanggan'),
        ];

        // Simpan transaksi ke database
        $this->penjualanModel->insert($data);

        $penjualanID = $this->penjualanModel->orderBy('PenjualanID', 'desc')->first();
        $detailPenjualan = $this->request->getPost('detailPenjualan');

        foreach($detailPenjualan as $detail) {
            $data2 = [
                'DetailID' => '',
                'PenjualanID' => $penjualanID['PenjualanID'],
                'ProdukID' => $detail['produkID'],
                'JumlahProduk' => $detail['qty'],
                'Subtotal' => $detail['subtotal'],
            ];

            $this->detailModel->insert($data2);
        }

        // Respon berhasil atau redirect ke halaman tertentu
        return redirect()->to(base_url('transaksi'));
    }
}
