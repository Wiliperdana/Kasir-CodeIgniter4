<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    public function index()
    {
        return view('login');
    }

    public function login()
    {
        $session = session();
        $userModel = new User();

        $username = $this->request->getPost('username');
        $password = $this->request->getVar('password');

        $data = $userModel->where('username', $username)->first();

        if (!empty($data) > 0) {
            $pass = $data['password'];
            if ($password == $pass) {
                $ses_data = [
                    'id_user' => $data['id_user'],
                    'nama' => $data['nama'],
                    'username' => $data['username'],
                    'role' => $data['role'],
                    'logged_in' => true
                ];
                $session->set($ses_data);
                switch ($data['role']) {
                    case 'admin':
                        return redirect()->to(base_url('dashboard'));
                        break;
                    case 'kasir' :
                        return redirect()->to(base_url('transaksi'));
                        break;
                    default :
                        return redirect()->to(base_url());
                }
            } else {
                $session->setFlashData('msg', 'Password Tidak Sesuai');
                return redirect()->to(base_url());
            }
        } else {
            $session->setFlashData('msg','User Tidak Ditemukan');
            return redirect()->to(base_url());
        }
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(base_url());
    }

    public function unauthorized() {
        return view('404');
    }
}
