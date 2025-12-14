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
        // ================= KPI =================
        $total            = $this->laporanModel->getTotalLaporan();
        $completionRate   = $this->laporanModel->getCompletionRate();
        $avgSelesai       = $this->laporanModel->getAvgWaktuSelesai();
        $highRisk         = $this->laporanModel->getHighRiskAktif();
        $bulanIni         = $this->laporanModel->getLaporanBulanIni();

        // ================= GRAFIK =================
        $trendBulanan     = $this->laporanModel->getTrendBulanan();
        $prioritas        = $this->laporanModel->getDistribusiPrioritas();
        $gedung           = $this->laporanModel->getLaporanPerGedung();

        // ================= OPERASIONAL =================
        $laporanTerbaru   = $this->laporanModel->getLaporanTerbaru();
        $adminPerformance = $this->laporanModel->getKinerjaAdmin();
        $notifikasi       = $this->laporanModel->getNotifikasiAktif();

        return view('admin/dashboard', compact(
            'total',
            'completionRate',
            'avgSelesai',
            'highRisk',
            'bulanIni',
            'trendBulanan',
            'prioritas',
            'gedung',
            'laporanTerbaru',
            'adminPerformance',
            'notifikasi'
        ));
    }
}
