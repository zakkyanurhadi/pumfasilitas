<?php
namespace App\Models;

use CodeIgniter\Model;

class LogAktivitasModel extends Model
{
    protected $table = 'log_aktivitas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['admin_id', 'laporan_id', 'aktivitas', 'waktu'];
    protected $useTimestamps = false; // Karena kolom 'waktu' manual

    // Fungsi helper untuk mencatat log
    public function catat($adminId, $aktivitas, $laporanId = null)
    {
        return $this->insert([
            'admin_id' => $adminId,
            'laporan_id' => $laporanId,
            'aktivitas' => $aktivitas,
            'waktu' => date('Y-m-d H:i:s')
        ]);
    }
}
