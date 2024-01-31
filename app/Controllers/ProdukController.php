<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Produk;

class ProdukController extends BaseController
{
    protected $produkModel;

    public function __construct()
    {
        $this->produkModel = new Produk();
    }

    public function index()
    {
        $data['produks'] = $this->produkModel->findAll();

        return view('admin/produk', $data);
    }

    public function get_data()
    {
        $data = $this->produkModel->findAll();

        return json_encode($data);
    }

    // public function store()
    // {
    //     $gambar = $this->request->getFile('Gambar');
    //     // $gambar->move(WRITEPATH . 'images');

    //     $data = [
    //         'NamaProduk' => $this->request->getPost('NamaProduk'),
    //         'Harga' => $this->request->getPost('Harga'),
    //         'Stok' => $this->request->getPost('Stok'),
    //         // 'Gambar' => $gambar->getName()
    //     ];
    //     $this->produkModel->insert($data);

    //     return redirect()->to(base_url('produk'));
    // }

    public function store()
    {
        $gambar = $this->request->getFile('Gambar');

        // Check if the file was uploaded successfully
        if ($gambar->isValid() && !$gambar->hasMoved())
        {
            try {
                // Move the uploaded file to the 'public/images' directory
                $gambar->move(FCPATH . 'images');

                $data = [
                    'NamaProduk' => $this->request->getPost('NamaProduk'),
                    'Harga' => $this->request->getPost('Harga'),
                    'Stok' => $this->request->getPost('Stok'),
                    'Gambar' => $gambar->getName()
                ];

                $this->produkModel->insert($data);

                return redirect()->to(base_url('produk'));
            } catch (\Exception $e) {
                // Log or handle the exception
                log_message('error', 'Exception: ' . $e->getMessage());
                return $this->response->setStatusCode(500)->setJSON(['error' => 'Internal Server Error']);
            }
        }
        else
        {
            // Handle file upload error
            return $this->response->setStatusCode(500)->setJSON(['error' => 'File upload failed']);
        }
    }


    public function edit()
    {
        $id = $this->request->getVar('ProdukID');
        $data = $this->produkModel->find($id);

        return json_encode($data);
    }

    public function update()
    {
        $id = $this->request->getPost('ProdukID');
        $data = [
            'NamaProduk' => $this->request->getPost('NamaProduk'),
            'Harga' => $this->request->getPost('Harga'),
            'Stok' => $this->request->getPost('Stok'),
        ];
        $this->produkModel->update($id, $data);

        return 'success';
    }

    public function delete()
    {
        $id = $this->request->getPost('ProdukID');

        $this->produkModel->delete($id);

        return 'delete success';
    }
}
