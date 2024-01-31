<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Pelanggan;
use CodeIgniter\HTTP\ResponseInterface;

class PelangganController extends BaseController
{
    public function index()
    {
        return view('admin/pelanggan');
    }

    public function get_data()
    {
        $pelangganModel = new Pelanggan();
        $data = $pelangganModel->findAll();

        return json_encode($data);
    }

    public function store()
    {
        $pelangganModel = new Pelanggan();
        $data = [
            'NamaPelanggan' => $this->request->getPost('nama'),
            'Alamat' => $this->request->getPost('alamat'),
            'NomorTelepon' => $this->request->getPost('telp'),
        ];
        $pelangganModel->insert($data);

        return redirect()->to(base_url('pelanggan'));
    }

    public function edit()
    {
        $id = $this->request->getVar('PelangganID');
        $pelangganModel = new Pelanggan();
        $data = $pelangganModel->find($id);

        return json_encode($data);
    }

    public function update()
    {
        $pelangganModel = new Pelanggan();
        $id = $this->request->getPost('PelangganID');
        $data = [
            'NamaPelanggan' => $this->request->getPost('NamaPelanggan'),
            'Alamat' => $this->request->getPost('Alamat'),
            'NomorTelepon' => $this->request->getPost('NomorTelepon'),
        ];
        $pelangganModel->update($id, $data);

        return 'success';
    }

    public function delete()
    {
        $pelangganModel = new Pelanggan();
        $id = $this->request->getPost('PelangganID');

        $pelangganModel->delete($id);

        return 'delete success';
    }
}
