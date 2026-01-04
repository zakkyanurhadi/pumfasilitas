<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LaporanModel;

class AdminDashboard extends BaseController
{
    protected LaporanModel $laporanModel;

    public function __construct()
    {
        $this->laporanModel = new LaporanModel();
    }

    public function index()
    {
        // Cache dashboard data for 10 minutes (600 seconds)
        $cache = \Config\Services::cache();
        $cacheKey = 'admin_dashboard_data';

        if (!$data = $cache->get($cacheKey)) {
            // ================= KPI =================
            $data['total'] = $this->laporanModel->getTotalLaporan();
            $data['completionRate'] = $this->laporanModel->getCompletionRate();
            $data['avgSelesai'] = $this->laporanModel->getAvgWaktuSelesai();
            $data['highRisk'] = $this->laporanModel->getHighRiskAktif();
            $data['bulanIni'] = $this->laporanModel->getLaporanBulanIni();

            // ================= GRAFIK =================
            // Ambil data trend untuk tahun ini dan tahun sebelumnya
            $currentYear = (int) date('Y');
            $data['trendBulanan'] = [
                $currentYear => $this->laporanModel->getTrendBulanan($currentYear),
                $currentYear - 1 => $this->laporanModel->getTrendBulanan($currentYear - 1),
            ];
            $data['currentYear'] = $currentYear;

            $data['prioritas'] = $this->laporanModel->getDistribusiPrioritas();
            $data['gedung'] = $this->laporanModel->getLaporanPerGedung();

            // ================= OPERASIONAL =================
            $data['laporanTerbaru'] = $this->laporanModel->getLaporanTerbaru();
            $data['adminPerformance'] = $this->laporanModel->getKinerjaAdmin();
            $data['notifikasi'] = $this->laporanModel->getNotifikasiAktif();

            // Store in cache
            $cache->save($cacheKey, $data, 600);
        }

        return view('admin/dashboard', $data);
    }
}
