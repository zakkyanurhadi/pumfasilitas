<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RektorFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Cek apakah user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Cek apakah user memiliki role rektor
        $role = session()->get('role');
        if ($role !== 'rektor') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak! Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada aksi setelahnya
    }
}
