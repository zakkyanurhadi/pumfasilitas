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
            // Redirect sesuai role masing-masing
            if ($role === 'admin' || $role === 'superadmin') {
                return redirect()->to('/dashboardadmin')->with('error', 'Akses ditolak! Halaman ini untuk Rektor.');
            } else {
                return redirect()->to('/dashboard')->with('error', 'Akses ditolak! Halaman ini untuk Rektor.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada aksi setelahnya
    }
}
