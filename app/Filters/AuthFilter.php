<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->has('logged_in')) {
            return redirect()->to(base_url());
        }

        if(isset($arguments[0])) {
            $roles = explode(',', $arguments[0]);
            if(!in_array(session()->get('role'), $roles)) {
                return redirect()->to(base_url())->with('msg','Gagal Login');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
