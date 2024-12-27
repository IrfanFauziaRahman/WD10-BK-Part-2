<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $path = service('uri')->getPath();
        $role = session()->get('role');

        if (str_starts_with($path, 'admin') && $role !== 'admin') {
            return redirect()->to('/login');
        }
        if (str_starts_with($path, 'dokter') && $role !== 'dokter') {
            return redirect()->to('/login');
        }
        if (str_starts_with($path, 'pasien') && $role !== 'pasien') {
            return redirect()->to('/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}