<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanModel extends Model
{
    protected $table = 'laporan';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $protectFields = true;
    protected $allowedFields = [
        'nama_pelapor',
        'lokasi_kerusakan',
        'lokasi_spesifik',
        'deskripsi',
        'foto',
        'status',
        'user_id',
        'gedung_id',
        'prioritas',
        'kategori',
        'admin_verifikator',
        'tanggal_verifikasi',
        'keterangan_verifikasi',
        'created_at',
        'updated_at',
    ];
    /* ================= KPI ================= */

    public function getTotalLaporan()
    {
        // Gunakan query builder baru setiap kali
        return $this->builder()->countAllResults();
    }

    public function getStatistik()
    {
        return $this->select("
                COUNT(id) AS total,
                SUM(status = 'pending') AS pending,
                SUM(status = 'diproses') AS diproses,
                SUM(status = 'selesai') AS selesai,
                SUM(status = 'ditolak') AS ditolak
            ")
            ->get()
            ->getRowArray();
    }


    public function getCompletionRate()
    {
        $result = $this->builder()
            ->select("ROUND((SUM(CASE WHEN status='selesai' THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as rate")
            ->get()
            ->getRowArray();

        return $result['rate'] ?? 0;
    }

    public function getAvgWaktuSelesai()
    {
        $result = $this->builder()
            ->select("ROUND(AVG(TIMESTAMPDIFF(HOUR, created_at, tanggal_verifikasi))) as jam")
            ->where('status', 'selesai')
            ->get()
            ->getRowArray();

        return $result['jam'] ?? 0;
    }

    public function getHighRiskAktif()
    {
        return $this->builder()
            ->where('prioritas', 'high')
            ->where('status !=', 'selesai')
            ->countAllResults();
    }

    public function getLaporanBulanIni()
    {
        return $this->builder()
            ->where('MONTH(created_at)', date('m'))
            ->where('YEAR(created_at)', date('Y'))
            ->countAllResults();
    }

    /* ================= STATISTIK HOMEPAGE ================= */

    public function getTotalLaporanSelesai()
    {
        return $this->builder()
            ->where('status', 'selesai')
            ->countAllResults();
    }

    public function getAvgWaktuRespon()
    {
        $result = $this->builder()
            ->select("ROUND(AVG(TIMESTAMPDIFF(HOUR, created_at, COALESCE(tanggal_verifikasi, updated_at)))) AS avg_hours")
            ->where('status !=', 'pending')
            ->where('updated_at IS NOT NULL')
            ->get()
            ->getRowArray();

        return $result['avg_hours'] ?? null;
    }

    public function getFormattedAvgWaktuRespon()
    {
        $avgHours = $this->getAvgWaktuRespon();

        if (!$avgHours || $avgHours == 0) {
            return '24 Jam';
        }

        if ($avgHours < 24) {
            return round($avgHours) . ' Jam';
        } else {
            $days = round($avgHours / 24);
            return $days . ' Hari';
        }
    }

    public function getStatistikHomepage()
    {
        return [
            'total_laporan' => $this->getTotalLaporan(),
            'laporan_selesai' => $this->getTotalLaporanSelesai(),
            'rata_rata_respon' => $this->getFormattedAvgWaktuRespon(),
            'avg_hours' => $this->getAvgWaktuRespon()
        ];
    }

    /* ================= GRAFIK ================= */
    // ... method lainnya tetap sama
    /* ================= GRAFIK ================= */

    public function getTrendBulanan()
    {
        return $this->select("MONTH(created_at) bulan, COUNT(*) total")
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->findAll();
    }

    public function getDistribusiPrioritas()
    {
        return $this->select("prioritas, COUNT(*) total")
            ->groupBy('prioritas')
            ->findAll();
    }

    public function getLaporanPerGedung()
    {
        return $this->db->query("
            SELECT g.nama, COUNT(l.id) total
            FROM gedung g
            LEFT JOIN laporan l ON g.id = l.gedung_id
            GROUP BY g.id
            ORDER BY total DESC
            LIMIT 5
        ")->getResultArray();
    }

    /* ================= OPERASIONAL ================= */

    public function getLaporanTerbaru()
    {
        return $this->db->query("
            SELECT 
                l.id,
                g.nama AS gedung,
                l.status,
                l.prioritas,
                TIMESTAMPDIFF(HOUR, l.created_at, NOW()) AS umur_jam
            FROM laporan l
            LEFT JOIN gedung g ON g.id = l.gedung_id
            ORDER BY l.created_at DESC
            LIMIT 5
        ")->getResultArray();
    }

    public function getKinerjaAdmin()
    {
        return $this->db->query("
            SELECT u.nama, COUNT(*) total
            FROM log_aktivitas la
            JOIN users u ON u.id = la.admin_id
            GROUP BY la.admin_id
        ")->getResultArray();
    }

    public function getNotifikasiAktif()
    {
        // Untuk admin: notifikasi aktif = laporan pending yang menunggu verifikasi
        return $this->builder()
            ->where('status', 'pending')
            ->countAllResults();
    }
}
