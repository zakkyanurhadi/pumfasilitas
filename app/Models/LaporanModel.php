<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanModel extends Model
{
    protected $table            = 'laporan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama',
        'npm',
        'lokasi_kerusakan',
        'lokasi_spesifik',
        'kategori_kerusakan',
        'tingkat_prioritas',
        'deskripsi_kerusakan',
        'foto_kerusakan',
        'status',
        'keterangan_verifikasi',
        'verifikator',
        'tanggal_verifikasi',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Statistik umum untuk user dashboard
     */
    public function getStatistik()
    {
        $query = $this->select("
                COUNT(id) as total,
                SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'Diproses' THEN 1 ELSE 0 END) as diproses,
                SUM(CASE WHEN status = 'Selesai' THEN 1 ELSE 0 END) as selesai
            ")
            ->get()
            ->getRowArray();

        return [
            'total'     => $query['total'] ?? 0,
            'pending'   => $query['pending'] ?? 0,
            'diproses'  => $query['diproses'] ?? 0,
            'selesai'   => $query['selesai'] ?? 0,
        ];
    }

    /**
     * Statistik khusus dashboard admin
     */
    public function getAdminStatistik()
{
    $query = $this->select("
        COUNT(id) as total,
        SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) as pending,
        SUM(CASE WHEN status = 'Diproses' THEN 1 ELSE 0 END) as diproses,
        SUM(CASE WHEN status = 'Selesai' THEN 1 ELSE 0 END) as selesai
    ")
    ->get()
    ->getRowArray();

    return [
        'total'     => $query['total'] ?? 0,
        'pending'   => $query['pending'] ?? 0,
        'diproses'  => $query['diproses'] ?? 0,
        'selesai'   => $query['selesai'] ?? 0,
    ];
}

    /**
     * Ambil semua laporan untuk admin (dengan urutan terbaru)
     */
    public function getAllLaporan($perPage = 10)
    {
    return $this->orderBy('created_at', 'DESC')->paginate($perPage);
    }


    /**
     * Ambil laporan berdasarkan ID
     */
    public function getLaporanById($id)
    {
        return $this->where('id', $id)->first();
    }

    /**
     * Ambil laporan berdasarkan user (misal untuk pengguna biasa)
     */
    public function getLaporanByNpm($npm)
    {
        return $this->where('npm', $npm)->orderBy('created_at', 'DESC')->findAll();
    }

    /**
     * Laporan selesai + fitur pencarian keyword (untuk riwayat)
     */
    public function getLaporanSelesaiQuery($keyword = null)
    {
        $builder = $this->where('status', 'Selesai')->orderBy('updated_at', 'DESC');

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('lokasi_kerusakan', $keyword)
                ->orLike('kategori_kerusakan', $keyword)
                ->orLike('lokasi_spesifik', $keyword)
                ->groupEnd();
        }

        return $builder;
    }
}
