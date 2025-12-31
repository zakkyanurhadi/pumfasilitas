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
        $userId = session()->get('user_id');

        // Filter berdasarkan user_id yang login
        $query = $this->db->table('notifikasi n')
            ->select('n.id as notif_id, n.terbaca, l.id, l.nama_pelapor, l.lokasi_kerusakan, l.lokasi_spesifik, l.deskripsi, l.foto, l.kategori, l.status, l.prioritas, l.created_at, u.nama as user_nama, g.nama as gedung_nama')
            ->join('laporan l', 'l.id = n.laporan_id', 'left')
            ->join('users u', 'u.id = l.user_id', 'left')
            ->join('gedung g', 'g.id = l.gedung_id', 'left')
            ->where('n.user_id', $userId) // <--- FILTER PENTING
            ->orderBy('n.created_at', 'DESC');

        if ($filter === 'pending') {
            $query->where('l.status', 'pending')->where('n.terbaca', 0);
        } elseif ($filter === 'diproses') {
            $query->where('l.status', 'diproses')->where('n.terbaca', 0);
        } elseif ($filter === 'selesai') {
            $query->where('l.status', 'selesai')->where('n.terbaca', 0);
        } elseif ($filter === 'dibaca') {
            $query->where('n.terbaca', 1);
        } else {
            // Default: tampilkan yang belum dibaca
            if ($filter === 'semua') {
                $query->where('n.terbaca', 0);
            }
        }

        $laporan = $query->limit(50)->get()->getResultArray();

        // Stats filtered by User ID
        $stats = [
            'total' => $this->db->table('notifikasi')->where('user_id', $userId)->where('terbaca', 0)->countAllResults(false),
            'pending' => $this->db->table('notifikasi n')->join('laporan l', 'l.id = n.laporan_id')->where('n.user_id', $userId)->where('l.status', 'pending')->where('n.terbaca', 0)->countAllResults(false),
            'diproses' => $this->db->table('notifikasi n')->join('laporan l', 'l.id = n.laporan_id')->where('n.user_id', $userId)->where('l.status', 'diproses')->where('n.terbaca', 0)->countAllResults(false),
            'selesai' => $this->db->table('notifikasi n')->join('laporan l', 'l.id = n.laporan_id')->where('n.user_id', $userId)->where('l.status', 'selesai')->where('n.terbaca', 0)->countAllResults(false),
            'dibaca' => $this->db->table('notifikasi')->where('user_id', $userId)->where('terbaca', 1)->countAllResults(),
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
        $userId = session()->get('user_id');
        // Untuk admin, "unread" adalah jumlah notifikasi yang belum dibaca MILIKNYA
        $count = $this->db->table('notifikasi')
            ->where('user_id', $userId)
            ->where('terbaca', 0)
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
        $userId = session()->get('user_id');
        // Tandai semua notifikasi MILIK USER yang belum dibaca menjadi terbaca
        $this->db->table('notifikasi')
            ->where('user_id', $userId)
            ->where('terbaca', 0)
            ->update(['terbaca' => 1]);
        return redirect()->to('/admin/notifikasi');
    }

    /**
     * Tandai satu notifikasi sebagai 'dibaca'
     */
    public function markRead($id)
    {
        $userId = session()->get('user_id');
        $this->db->table('notifikasi')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->update(['terbaca' => 1]);

        return redirect()->to('/admin/notifikasi');
    }

    /**
     * Hapus/abaikan notifikasi laporan tertentu (redirect ke detail untuk diproses)
     */
    public function delete($id)
    {
        $userId = session()->get('user_id');
        $this->db->table('notifikasi')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->delete();
        return redirect()->to('/admin/notifikasi');
    }

    /**
     * Hapus semua notifikasi
     */
    public function deleteAll()
    {
        $userId = session()->get('user_id');
        $this->db->table('notifikasi')->where('user_id', $userId)->delete();
        return redirect()->to('/admin/notifikasi');
    }
}
