<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class DirekturFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Cek apakah user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Cek apakah user memiliki role direktur
        $role = session()->get('role');
        if ($role !== 'direktur') {
            // Redirect sesuai role masing-masing
            if ($role === 'admin1' || $role === 'admin') {
                return redirect()->to('/dashboardadmin1')->with('error', 'Akses ditolak! Halaman ini untuk Direktur.');
            } else {
                return redirect()->to('/dashboard')->with('error', 'Akses ditolak! Halaman ini untuk Direktur.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada aksi setelahnya
    }
}
