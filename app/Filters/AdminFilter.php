<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Cek apakah user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Cek apakah user memiliki role admin (superadmin lama)
        $role = session()->get('role');
        if ($role !== 'admin') {
            // Redirect sesuai role masing-masing
            if ($role === 'admin1') {
                return redirect()->to('/dashboardadmin1')->with('error', 'Akses ditolak! Halaman ini hanya untuk Admin.');
            } elseif ($role === 'direktur') {
                return redirect()->to('/direktur/dashboard')->with('error', 'Akses ditolak! Halaman ini hanya untuk Admin.');
            } else {
                return redirect()->to('/dashboard')->with('error', 'Akses ditolak! Halaman ini hanya untuk Admin.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada aksi setelahnya
    }
}
