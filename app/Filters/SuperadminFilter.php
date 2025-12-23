<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class SuperadminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Cek apakah user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Cek apakah user memiliki role superadmin
        $role = session()->get('role');
        if ($role !== 'superadmin') {
            // Redirect sesuai role masing-masing
            if ($role === 'admin') {
                return redirect()->to('/dashboardadmin')->with('error', 'Akses ditolak! Halaman ini hanya untuk Superadmin.');
            } elseif ($role === 'rektor') {
                return redirect()->to('/rektor/dashboard')->with('error', 'Akses ditolak! Halaman ini hanya untuk Superadmin.');
            } else {
                return redirect()->to('/dashboard')->with('error', 'Akses ditolak! Halaman ini hanya untuk Superadmin.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada aksi setelahnya
    }
}
