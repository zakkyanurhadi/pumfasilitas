<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\NotifikasiModel;

class NotifikasiController extends BaseController
{
    protected $notifikasiModel;
    protected $db;

    public function __construct()
    {
        $this->notifikasiModel = new NotifikasiModel();
        $this->db = \Config\Database::connect();
    }

    /**
     * Helper untuk mendapatkan user_id dari session
     */
    private function getUserId()
    {
        return session()->get('user_id')
            ?? session()->get('id')
            ?? (is_array(session()->get('user')) ? session()->get('user')['id'] : null);
    }

    /**
     * Halaman daftar notifikasi
     */
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $userId = $this->getUserId();

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Session tidak valid');
        }

        // Ambil filter
        $filter = $this->request->getGet('filter') ?? 'semua';

        // Query builder
        $query = $this->notifikasiModel->where('user_id', $userId);

        // Filter berdasarkan status baca
        if ($filter === 'belum') {
            $query->where('terbaca', 0);
        } elseif ($filter === 'sudah') {
            $query->where('terbaca', 1);
        }

        // Ambil notifikasi dengan data laporan
        $notifikasi = $this->db->table('notifikasi n')
            ->select('n.*, l.lokasi_kerusakan, l.status as status_laporan, l.kategori')
            ->join('laporan l', 'l.id = n.laporan_id', 'left')
            ->where('n.user_id', $userId);

        if ($filter === 'belum') {
            $notifikasi->where('n.terbaca', 0);
        } elseif ($filter === 'sudah') {
            $notifikasi->where('n.terbaca', 1);
        }

        $notifikasi = $notifikasi
            ->orderBy('n.created_at', 'DESC')
            ->get()
            ->getResultArray();

        // Statistik - use fresh model instances to avoid query builder state issues
        $stats = [
            'total' => (new NotifikasiModel())->where('user_id', $userId)->countAllResults(),
            'belum_dibaca' => (new NotifikasiModel())->where('user_id', $userId)->where('terbaca', 0)->countAllResults(),
            'sudah_dibaca' => (new NotifikasiModel())->where('user_id', $userId)->where('terbaca', 1)->countAllResults(),
        ];

        $data = [
            'title' => 'Notifikasi',
            'notifikasi' => $notifikasi,
            'stats' => $stats,
            'filter' => $filter,
        ];

        return view('notifikasi/index', $data);
    }

    /**
     * Tandai satu notifikasi sebagai terbaca
     */
    public function markAsRead($id)
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $userId = $this->getUserId();

        if (!$userId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Session tidak valid']);
        }

        $result = $this->notifikasiModel->markAsRead($id, $userId);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => $result,
                'unread_count' => $this->notifikasiModel->countUnread($userId)
            ]);
        }

        return redirect()->back()->with('success', 'Notifikasi ditandai sebagai terbaca');
    }

    /**
     * Tandai semua notifikasi sebagai terbaca
     */
    public function markAllAsRead()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $userId = $this->getUserId();

        if (!$userId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Session tidak valid']);
        }

        $result = $this->notifikasiModel->markAllAsRead($userId);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => true,
                'unread_count' => 0
            ]);
        }

        return redirect()->back()->with('success', 'Semua notifikasi ditandai sebagai terbaca');
    }

    /**
     * Hapus notifikasi
     */
    public function delete($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $userId = $this->getUserId();

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Session tidak valid');
        }

        $result = $this->notifikasiModel->deleteNotifikasi($id, $userId);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => $result,
                'unread_count' => $this->notifikasiModel->countUnread($userId)
            ]);
        }

        if ($result) {
            return redirect()->to('/notifikasi')->with('success', 'Notifikasi berhasil dihapus');
        }

        return redirect()->to('/notifikasi')->with('error', 'Gagal menghapus notifikasi');
    }

    /**
     * Hapus semua notifikasi
     */
    public function deleteAll()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $userId = $this->getUserId();

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Session tidak valid');
        }

        $result = $this->notifikasiModel->deleteAllByUser($userId);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Semua notifikasi berhasil dihapus'
            ]);
        }

        return redirect()->to('/notifikasi')->with('success', 'Semua notifikasi berhasil dihapus');
    }

    /**
     * API: Ambil jumlah notifikasi belum dibaca (untuk badge di navbar)
     */
    public function getUnreadCount()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['count' => 0]);
        }

        $userId = $this->getUserId();

        if (!$userId) {
            return $this->response->setJSON(['count' => 0]);
        }

        $count = $this->notifikasiModel->countUnread($userId);

        return $this->response->setJSON(['count' => $count]);
    }

    /**
     * Lihat detail dan tandai sebagai terbaca, lalu redirect ke laporan
     */
    public function view($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $userId = $this->getUserId();

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Session tidak valid');
        }

        // Ambil notifikasi
        $notifikasi = $this->notifikasiModel
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$notifikasi) {
            return redirect()->to('/notifikasi')->with('error', 'Notifikasi tidak ditemukan');
        }

        // Tandai sebagai terbaca
        $this->notifikasiModel->markAsRead($id, $userId);

        // Redirect ke detail laporan jika ada laporan_id
        if (!empty($notifikasi['laporan_id'])) {
            return redirect()->to('/laporan/detail/' . $notifikasi['laporan_id']);
        }

        return redirect()->to('/notifikasi');
    }
}
