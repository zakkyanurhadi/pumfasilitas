<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LaporanModel;

class AdminDashboard extends BaseController
{
    protected $laporanModel;

    public function __construct()
    {
        // Inisialisasi model
        $this->laporanModel = new LaporanModel();
    }

    public function index()
    {
        // Ambil data statistik khusus untuk admin
        $statistik = $this->laporanModel->getAdminStatistik(); // Buat method ini di LaporanModel
        $keyword = $this->request->getGet('keyword');
        $model = new LaporanModel();

        // Siapkan data untuk dikirim ke view
        $data['laporan'] = $model->getLaporanSelesaiQuery($keyword)->paginate(10);
        $data['pager_links'] = $model->pager->links();
        $data = [
            'title' => 'Dashboard Admin',
            'user'  => [
                'nama' => session('nama'),
                'npm'  => session('npm'),
            ],
            'stats' => $statistik,
        ];

        // Tampilkan view khusus dashboard admin
        return view('admin/dashboard', $data);
    }
}

