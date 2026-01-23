<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Admin1Filter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Cek apakah user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Cek apakah user memiliki role admin1 atau admin (superadmin lama)
        $role = session()->get('role');
        if ($role !== 'admin1' && $role !== 'admin') {
            // Redirect sesuai role masing-masing
            if ($role === 'direktur') {
                return redirect()->to('/direktur/dashboard')->with('error', 'Akses ditolak! Halaman ini untuk Admin.');
            } else {
                return redirect()->to('/dashboard')->with('error', 'Akses ditolak! Halaman ini untuk Admin.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada aksi setelahnya
    }
}
