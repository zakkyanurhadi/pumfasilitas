<?php

namespace App\Controllers;

use App\Models\LaporanModel;
use App\Models\NotifikasiModel;

class AdminLaporController extends BaseController
{
    protected $laporanModel;

    public function __construct()
    {
        $this->laporanModel = new LaporanModel();
    }

    /* ============================================================
       HALAMAN UTAMA LAPORAN (PENDING + DIPROSES + SELESAI)
    ============================================================ */
    public function index()
    {
        $db = \Config\Database::connect();
        $pager = \Config\Services::pager();
        $perPage = 10;

        $uri = service('uri')->getSegment(1);  // dapatkan segment URL

        // Tentukan status sesuai halaman
        $statusMapper = [
            'laporanadminpending' => 'pending',
            'laporanadmindiproses' => 'diproses',
            'riwayatadmin' => 'selesai'
        ];

        $statusFilter = $statusMapper[$uri] ?? '';

        $keyword = $this->request->getGet('keyword');
        $currentPage = $this->request->getGet('page') ?? 1;

        $builder = $db->table('laporan');

        // Filter status otomatis berdasarkan halaman
        if ($statusFilter != '') {
            $builder->where('status', $statusFilter);
        }

        // Search
        if ($keyword) {
            $builder->groupStart()
                ->like('lokasi_kerusakan', $keyword)
                ->orLike('kategori', $keyword)
                ->orLike('nama_pelapor', $keyword)
                ->groupEnd();
        }

        $builder->orderBy('created_at', 'DESC');

        $total = $builder->countAllResults(false);

        $laporan = $builder->get($perPage, ($currentPage - 1) * $perPage)->getResultArray();

        // Pagination dengan query string
        $pager_links = $pager->makeLinks(
            $currentPage,
            $perPage,
            $total,
            'default_full',
            0,
            '',
            $this->request->getGet()
        );

        // Ambil detail jika dipilih - dengan JOIN ke users dan gedung
        $detailId = $this->request->getGet('detail');
        $detail = null;
        if ($detailId) {
            $detail = $db->table('laporan l')
                ->select('l.*, u.npm as username, u.nama as user_nama, g.nama as nama_gedung')
                ->join('users u', 'u.id = l.user_id', 'left')
                ->join('gedung g', 'g.id = l.gedung_id', 'left')
                ->where('l.id', $detailId)
                ->get()
                ->getRowArray();
        }

        return view('admin/laporan', [
            'title' => 'Halaman Laporan',
            'laporan' => $laporan,
            'pager_links' => $pager_links,
            'keyword' => $keyword,
            'statusFilter' => $statusFilter,
            'currentPage' => $currentPage,
            'perPage' => $perPage,
            'detail' => $detail,
            'uri' => $uri
        ]);
    }

    /* ============================================================
       RIWAYAT LAPORAN SELESAI
    ============================================================ */
    public function riwayat()
    {
        $db = \Config\Database::connect();
        $pager = \Config\Services::pager();
        $perPage = 5;

        $builder = $db->table('laporan');
        $builder->where('status', 'selesai');  // lowercase agar match data

        $keyword = $this->request->getGet('keyword');

        // SEARCH
        if ($keyword) {
            $builder->groupStart()
                ->like('lokasi_kerusakan', $keyword)
                ->orLike('kategori', $keyword)
                ->orLike('nama', $keyword)
                ->groupEnd();
        }

        $builder->orderBy('updated_at', 'DESC');

        $currentPage = $this->request->getGet('page') ?? 1;

        $total = $builder->countAllResults(false);

        $laporan = $builder->get($perPage, ($currentPage - 1) * $perPage)->getResultArray();

        // PAGINATION — QUERY STRING TETAP ADA
        $query = $this->request->getGet();
        $pager_links = $pager->makeLinks(
            $currentPage,
            $perPage,
            $total,
            'default_full',
            0,
            '',
            $query
        );

        // GET DETAIL - dengan JOIN ke users dan gedung
        $detailId = $this->request->getGet('detail');
        $detail = null;

        if ($detailId) {
            $detail = $db->table('laporan l')
                ->select('l.*, u.npm as username, u.nama as user_nama, g.nama as nama_gedung')
                ->join('users u', 'u.id = l.user_id', 'left')
                ->join('gedung g', 'g.id = l.gedung_id', 'left')
                ->where('l.id', $detailId)
                ->get()
                ->getRowArray();
        }

        return view('admin/riwayat', [
            'title' => 'Riwayat Laporan Selesai',
            'laporan' => $laporan,
            'pager_links' => $pager_links,
            'keyword' => $keyword,
            'currentPage' => $currentPage,
            'perPage' => $perPage,
            'detail' => $detail
        ]);
    }

    /* ============================================================
       VERIFIKASI LAPORAN
    ============================================================ */
    public function verifikasi()
    {
        $id = $this->request->getPost('laporan_id');

        // Debug: Log request data
        log_message('debug', 'Verifikasi Request - ID: ' . $id);
        log_message('debug', 'Verifikasi Request - All POST: ' . json_encode($this->request->getPost()));

        if (!$id) {
            log_message('error', 'Verifikasi gagal: ID laporan kosong');
            return redirect()->back()->with('error', 'ID laporan kosong');
        }

        $rules = [
            'status' => 'required|in_list[pending,diproses,selesai,ditolak]',
            'keterangan_verifikasi' => 'required|min_length[5]'
        ];

        if (!$this->validate($rules)) {
            $errors = $this->validator->getErrors();
            log_message('error', 'Verifikasi gagal validasi: ' . json_encode($errors));
            return redirect()->back()->withInput()->with('error', 'Validasi gagal: ' . implode(', ', $errors));
        }

        $dataUpdate = [
            'status' => $this->request->getPost('status'),
            'tanggal_verifikasi' => date('Y-m-d H:i:s'),
            'verifikator' => session('nama'),
            'keterangan_verifikasi' => $this->request->getPost('keterangan_verifikasi')
        ];

        log_message('debug', 'Data Update: ' . json_encode($dataUpdate));

        try {
            $result = $this->laporanModel->update($id, $dataUpdate);

            if ($result) {
                log_message('info', 'Verifikasi berhasil untuk laporan #' . $id);

                // Log Aktivitas
                $logModel = new \App\Models\LogAktivitasModel();
                $adminId = session()->get('user_id');
                $status = $this->request->getPost('status');
                $dataLog = "Memverifikasi laporan #$id menjadi $status";
                $logModel->catat($adminId, $dataLog, $id);

                // ==========================================
                // BUAT NOTIFIKASI UNTUK USER
                // ==========================================
                $laporan = $this->laporanModel->find($id);
                if ($laporan && !empty($laporan['user_id'])) {
                    $notifikasiModel = new NotifikasiModel();

                    // Buat pesan notifikasi berdasarkan status
                    $statusLabels = [
                        'pending' => 'menunggu verifikasi',
                        'diproses' => 'sedang diproses',
                        'selesai' => 'telah selesai dikerjakan',
                        'ditolak' => 'ditolak'
                    ];
                    $statusLabel = $statusLabels[$status] ?? $status;

                    $pesanNotif = "Laporan Anda di " . ($laporan['lokasi_kerusakan'] ?? 'lokasi tersebut');
                    $pesanNotif .= " {$statusLabel}.";

                    if (!empty($dataUpdate['keterangan_verifikasi'])) {
                        $pesanNotif .= " Keterangan: " . $dataUpdate['keterangan_verifikasi'];
                    }

                    $notifikasiModel->createNotifikasi(
                        $laporan['user_id'],
                        $id,
                        $pesanNotif
                    );

                    log_message('info', 'Notifikasi dibuat untuk user #' . $laporan['user_id']);
                }

                return redirect()->back()->with('success', 'Verifikasi berhasil disimpan');
            } else {
                log_message('error', 'Update gagal untuk laporan #' . $id);
                return redirect()->back()->with('error', 'Gagal menyimpan verifikasi');
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception saat verifikasi: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }


    /* ============================================================
       HALAMAN DETAIL (OPSIONAL — MASIH DIPERLUKAN)
    ============================================================ */
    public function detail($id)
    {
        $db = \Config\Database::connect();

        // Query dengan JOIN ke users dan gedung
        $laporan = $db->table('laporan l')
            ->select('l.*, u.npm as username, u.nama as user_nama, g.nama as nama_gedung')
            ->join('users u', 'u.id = l.user_id', 'left')
            ->join('gedung g', 'g.id = l.gedung_id', 'left')
            ->where('l.id', $id)
            ->get()
            ->getRowArray();

        if (!$laporan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Laporan tidak ditemukan ID: ' . $id);
        }

        return view('admin/detail', [
            'title' => 'Detail Laporan',
            'laporan' => $laporan,
        ]);
    }
}
