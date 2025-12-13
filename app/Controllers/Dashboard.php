<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LaporanModel;
use App\Models\GedungModel;
use App\Models\KategoriModel;
use App\Models\PrioritasModel;

class Dashboard extends BaseController
{
    public function index()
    {
        // Model
        $laporanModel   = new LaporanModel();
        $gedungModel    = new GedungModel();
        $kategoriModel  = new KategoriModel();
        $prioritasModel = new PrioritasModel();

        // Statistik laporan untuk user
        $statistik = $laporanModel->getStatistik();

        // Ambil data dropdown dari database
        $gedung    = $gedungModel->findAll();
        $kategori  = $kategoriModel->findAll();
        $prioritas = $prioritasModel->findAll();

        // Data yang dikirim ke view
        $data = [
            'title'     => 'Dashboard Utama',
            'user'      => [
                'nama' => session('nama'),
                'npm'  => session('npm'),
            ],
            'stats'     => $statistik,
            'gedung'    => $gedung,
            'kategori'  => $kategori,
            'prioritas' => $prioritas,
        ];

        return view('dashboard/index', $data);
    }
}
