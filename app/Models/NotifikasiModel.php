<?php

namespace App\Models;

use CodeIgniter\Model;

class NotifikasiModel extends Model
{
    protected $table = 'notifikasi';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $protectFields = true;
    protected $allowedFields = [
        'user_id',
        'laporan_id',
        'pesan',
        'terbaca',
        'created_at',
    ];

    protected $useTimestamps = false;

    /**
     * Ambil semua notifikasi untuk user tertentu
     */
    public function getByUserId($userId, $limit = 50)
    {
        return $this->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    /**
     * Ambil notifikasi dengan data laporan (JOIN)
     */
    public function getWithLaporan($userId, $limit = 50)
    {
        return $this->db->table('notifikasi n')
            ->select('n.*, l.lokasi_kerusakan, l.status as status_laporan, l.kategori')
            ->join('laporan l', 'l.id = n.laporan_id', 'left')
            ->where('n.user_id', $userId)
            ->orderBy('n.created_at', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }

    /**
     * Hitung notifikasi yang belum terbaca
     */
    public function countUnread($userId)
    {
        return $this->where('user_id', $userId)
            ->where('terbaca', 0)
            ->countAllResults();
    }

    /**
     * Tandai notifikasi sebagai terbaca
     */
    public function markAsRead($id, $userId)
    {
        return $this->where('id', $id)
            ->where('user_id', $userId)
            ->set(['terbaca' => 1])
            ->update();
    }

    /**
     * Tandai semua notifikasi user sebagai terbaca
     */
    public function markAllAsRead($userId)
    {
        return $this->where('user_id', $userId)
            ->where('terbaca', 0)
            ->set(['terbaca' => 1])
            ->update();
    }

    /**
     * Buat notifikasi baru
     */
    public function createNotifikasi($userId, $laporanId, $pesan)
    {
        return $this->insert([
            'user_id' => $userId,
            'laporan_id' => $laporanId,
            'pesan' => $pesan,
            'terbaca' => 0,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Hapus notifikasi
     */
    public function deleteNotifikasi($id, $userId)
    {
        return $this->where('id', $id)
            ->where('user_id', $userId)
            ->delete();
    }

    /**
     * Hapus semua notifikasi user
     */
    public function deleteAllByUser($userId)
    {
        return $this->where('user_id', $userId)->delete();
    }
}
