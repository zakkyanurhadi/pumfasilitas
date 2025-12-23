<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\NotifikasiModel;
use App\Models\LaporanModel;

class AdminNotifikasiController extends BaseController
{
    protected $notifikasiModel;
    protected $laporanModel;
    protected $db;

    public function __construct()
    {
        $this->notifikasiModel = new NotifikasiModel();
        $this->laporanModel = new LaporanModel();
        $this->db = \Config\Database::connect();
    }

    /**
     * Halaman daftar notifikasi admin (laporan baru masuk)
     */
    public function index()
    {
        $filter = $this->request->getGet('filter') ?? 'semua';

        // Untuk admin, notifikasi adalah laporan dengan data lengkap untuk detail inline
        $query = $this->db->table('laporan l')
            ->select('l.id, l.nama_pelapor, l.lokasi_kerusakan, l.lokasi_spesifik, l.deskripsi, l.foto, l.kategori, l.status, l.prioritas, l.created_at, u.nama as user_nama, g.nama as gedung_nama')
            ->join('users u', 'u.id = l.user_id', 'left')
            ->join('gedung g', 'g.id = l.gedung_id', 'left')
            ->orderBy('l.created_at', 'DESC');

        if ($filter === 'pending') {
            $query->where('l.status', 'pending');
        } elseif ($filter === 'diproses') {
            $query->where('l.status', 'diproses');
        }

        $laporan = $query->limit(50)->get()->getResultArray();

        // Stats
        $stats = [
            'total' => $this->db->table('laporan')->countAllResults(false),
            'pending' => $this->db->table('laporan')->where('status', 'pending')->countAllResults(false),
            'diproses' => $this->db->table('laporan')->where('status', 'diproses')->countAllResults(),
        ];

        return view('admin/notifikasi/index', [
            'title' => 'Notifikasi Admin',
            'laporan' => $laporan,
            'stats' => $stats,
            'filter' => $filter,
        ]);
    }

    /**
     * API: Hitung laporan pending (untuk badge admin)
     */
    public function getUnreadCount()
    {
        // Untuk admin, "unread" adalah jumlah laporan pending
        $count = $this->db->table('laporan')
            ->where('status', 'pending')
            ->countAllResults();

        return $this->response->setJSON(['count' => $count]);
    }

    /**
     * Redirect ke detail laporan
     */
    public function view($id)
    {
        return redirect()->to('/admindetail/' . $id);
    }

    /**
     * Tandai semua laporan pending sebagai terbaca (redirect ke halaman diproses)
     * Dalam konteks admin, ini bisa berarti mengarahkan ke halaman proses
     */
    public function markAllAsRead()
    {
        // Untuk admin, "mark all as read" bisa berarti redirect ke halaman laporan pending
        // Atau bisa juga update status - tergantung kebutuhan bisnis
        return redirect()->to('/laporanadminpending')->with('success', 'Silakan proses laporan pending');
    }

    /**
     * Hapus/abaikan notifikasi laporan tertentu (redirect ke detail untuk diproses)
     */
    public function delete($id)
    {
        // Dalam konteks admin, "delete" notifikasi berarti mengarahkan ke detail untuk diproses
        // Karena admin tidak bisa menghapus laporan dari notifikasi, hanya bisa memprosesnya
        return redirect()->to('/admindetail/' . $id);
    }
}
