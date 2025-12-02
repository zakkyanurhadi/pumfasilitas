<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LaporanModel; // 1. Panggil LaporanModel

class Dashboard extends BaseController
{
    public function index()
    {
        // 2. Buat instance dari LaporanModel
        $laporanModel = new LaporanModel();

        // 3. Ambil data statistik dari method getStatistik()
        $statistik = $laporanModel->getStatistik();

        // Siapkan data yang akan dikirim ke view
        $data = [
            'title' => 'Dashboard Utama',
            'user'  => [ // Data session tetap sama
                'nama' => session('nama'),
                'npm'  => session('npm'),
            ],
            // 4. Gunakan data statistik dari database, bukan data statis
            'stats' => $statistik,
        ];

        // Tampilkan view dashboard dan kirimkan datanya
        return view('dashboard/index', $data);
    }
}
