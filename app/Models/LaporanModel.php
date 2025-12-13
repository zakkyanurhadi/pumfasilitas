<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanModel extends Model
{
    protected $table = 'laporan';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    /* ================= KPI ================= */

    public function getTotalLaporan()
    {
        return $this->countAllResults();
    }

    public function getCompletionRate()
    {
        return $this->select("
            ROUND((SUM(status='selesai') / COUNT(*)) * 100,2) rate
        ")->get()->getRow()->rate ?? 0;
    }

    public function getAvgWaktuSelesai()
    {
        return $this->select("
            ROUND(AVG(TIMESTAMPDIFF(HOUR, created_at, tanggal_verifikasi)))
            AS jam
        ")
        ->where('status', 'selesai')
        ->get()->getRow()->jam ?? 0;
    }

    public function getHighRiskAktif()
    {
        return $this->where('prioritas', 'high')
                    ->where('status !=', 'selesai')
                    ->countAllResults();
    }

    public function getLaporanBulanIni()
    {
        return $this->where('MONTH(created_at)', date('m'))
                    ->countAllResults();
    }

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
        return $this->db->table('notifikasi')
                        ->where('terbaca', 0)
                        ->countAllResults();
    }
}
