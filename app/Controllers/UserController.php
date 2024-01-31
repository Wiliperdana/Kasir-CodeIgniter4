<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    public function index()
    {
        return view('admin/user');
    }

    public function get_data()
    {
        $userModel = new User();
        $data = $userModel->findAll();

        return json_encode($data);
    }

    public function store()
    {
        $userModel = new User();

        $data = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'),
            'role' => $this->request->getPost('role'),
        ];
        $userModel->insert($data);

        return redirect()->to(base_url('user'));
    }

    public function edit()
    {
        $id = $this->request->getVar('id_user');
        $userModel = new User();
        $data = $userModel->find($id);

        return json_encode($data);
    }

    public function update()
    {
        $userModel = new User();
        $id = $this->request->getPost('id_user');
        $data = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'),
            'role' => $this->request->getPost('role'),
        ];
        $userModel->update($id, $data);

        return 'success';
    }

    public function delete()
    {
        $userModel = new User();
        $id = $this->request->getPost('id_user');

        $userModel->delete($id);

        return 'delete success';
    }
}
