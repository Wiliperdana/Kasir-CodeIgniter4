<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // if (! session()->has('logged_in')) {
        //     return redirect()->to(base_url());
        // }

        // if(isset($arguments[0])) {
        //     $roles = explode(',', $arguments[0]);
        //     if(!in_array(session()->get('role'), $roles)) {
        //         return redirect()->to(base_url())->with('msg','Gagal Login');
        //     }
        // }
        
        // if (isset($arguments[0])) {
        //     $allowedRoles = explode(',', $arguments[0]);
        //     $userRole = session()->get('role');

        //     if (!in_array($userRole, $allowedRoles)) {
        //         return redirect()->to(base_url('404'))->with('msg', 'Access denied. Insufficient privileges.');
        //     }
        // }
        
        // Cek apakah user sudah login
        if (! session()->get('logged_in')) {
            // Jika belum login, arahkan ke halaman login
            return redirect()->to('/');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
