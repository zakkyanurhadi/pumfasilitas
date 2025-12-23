<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LaporanModel;
use App\Models\GedungModel;

class RektorController extends BaseController
{
    protected $laporanModel;
    protected $gedungModel;

    public function __construct()
    {
        $this->laporanModel = new LaporanModel();
        $this->gedungModel = new GedungModel();
    }

    // 1. DASHBOARD REKTOR
    public function index()
    {
        // Gunakan statistik yang sudah ada di LaporanModel
        $stats = $this->laporanModel->getStatistikHomepage();
        $chartPrioritas = $this->laporanModel->getDistribusiPrioritas();
        $chartBulanan = $this->laporanModel->getTrendBulanan();

        return view('rektor/dashboard', [
            'title' => 'Dashboard Rektor',
            'stats' => $stats,
            'chartPrioritas' => $chartPrioritas,
            'chartBulanan' => $chartBulanan,
        ]);
    }

    // 2. DAFTAR LAPORAN (READ-ONLY)
    public function laporan()
    {
        $keyword = $this->request->getGet('keyword');
        $status = $this->request->getGet('status');
        $gedung = $this->request->getGet('gedung');
        $prioritas = $this->request->getGet('prioritas');

        $pager = \Config\Services::pager();
        $perPage = 10;
        $currentPage = $this->request->getGet('page') ?? 1;

        $builder = $this->laporanModel->builder();
        $builder->select('laporan.*, gedung.nama as nama_gedung, ruangan.nama_ruangan');
        $builder->join('gedung', 'gedung.id = laporan.gedung_id', 'left');
        $builder->join('ruangan', 'ruangan.id = laporan.ruangan_id', 'left');

        // Filter
        if ($keyword) {
            $builder->groupStart()
                ->like('laporan.deskripsi', $keyword)
                ->orLike('laporan.nama_pelapor', $keyword)
                ->groupEnd();
        }
        if ($status)
            $builder->where('laporan.status', $status);
        if ($gedung)
            $builder->where('laporan.gedung_id', $gedung);
        if ($prioritas)
            $builder->where('laporan.prioritas', $prioritas);

        $builder->orderBy('laporan.created_at', 'DESC');

        // Pagination Manual karena custom join builder
        $total = $builder->countAllResults(false);
        $laporan = $builder->get($perPage, ($currentPage - 1) * $perPage)->getResultArray();

        $pager_links = $pager->makeLinks($currentPage, $perPage, $total, 'default_full');

        // Data untuk dropdown filter
        $listGedung = $this->gedungModel->findAll();

        return view('rektor/laporan', [
            'title' => 'Daftar Laporan',
            'laporan' => $laporan,
            'pager_links' => $pager_links,
            'listGedung' => $listGedung,
            'filters' => compact('keyword', 'status', 'gedung', 'prioritas')
        ]);
    }

    // 3. STATISTIK PENGADUAN
    public function statistik()
    {
        $bulanIni = $this->laporanModel->getLaporanBulanIni();
        $total = $this->laporanModel->getTotalLaporan();

        $chartGedung = $this->laporanModel->getLaporanPerGedung();
        $chartKategori = $this->laporanModel->select('kategori, count(*) as total')->groupBy('kategori')->findAll();
        $trendTahunan = $this->laporanModel->getTrendBulanan(); // Reuse

        return view('rektor/statistik', [
            'title' => 'Statistik Pengaduan',
            'total' => $total,
            'bulanIni' => $bulanIni,
            'chartGedung' => $chartGedung,
            'chartKategori' => $chartKategori,
            'trendTahunan' => $trendTahunan
        ]);
    }

    // 4. AUDIT LOG
    public function auditLog()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('log_aktivitas');
        $builder->select('log_aktivitas.*, users.nama as nama_user');
        $builder->join('users', 'users.id = log_aktivitas.admin_id', 'left');
        $builder->orderBy('waktu', 'DESC');

        $pager = \Config\Services::pager();
        $perPage = 15;
        $currentPage = $this->request->getGet('page') ?? 1;

        $total = $builder->countAllResults(false);
        $logs = $builder->get($perPage, ($currentPage - 1) * $perPage)->getResultArray();

        $pager_links = $pager->makeLinks($currentPage, $perPage, $total, 'default_full');

        return view('rektor/audit_log', [
            'title' => 'Audit Log',
            'logs' => $logs,
            'pager_links' => $pager_links
        ]);
    }
}
