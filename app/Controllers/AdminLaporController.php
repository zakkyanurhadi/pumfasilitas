<?php

namespace App\Controllers;

use App\Models\LaporanModel;

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

        // Ambil detail jika dipilih
        $detailId = $this->request->getGet('detail');
        $detail = null;
        if ($detailId) {
            $detail = $db->table('laporan')->where('id', $detailId)->get()->getRowArray();
        }

        return view('admin/laporan', [
            'title'        => 'Halaman Laporan',
            'laporan'      => $laporan,
            'pager_links'  => $pager_links,
            'keyword'      => $keyword,
            'statusFilter' => $statusFilter,
            'currentPage'  => $currentPage,
            'perPage'      => $perPage,
            'detail'       => $detail,
            'uri'          => $uri
        ]);
    }

    /* ============================================================
       RIWAYAT LAPORAN SELESAI
    ============================================================ */
    public function riwayat()
    {
        $db    = \Config\Database::connect();
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

        // GET DETAIL
        $detailId = $this->request->getGet('detail');
        $detail = null;

        if ($detailId) {
            $detail = $db->table('laporan')->where('id', $detailId)->get()->getRowArray();
        }

        return view('admin/riwayat', [
            'title'       => 'Riwayat Laporan Selesai',
            'laporan'     => $laporan,
            'pager_links' => $pager_links,
            'keyword'     => $keyword,
            'currentPage' => $currentPage,
            'perPage'     => $perPage,
            'detail'      => $detail
        ]);
    }

    /* ============================================================
       VERIFIKASI LAPORAN
    ============================================================ */
    public function verifikasi()
    {
        $id = $this->request->getPost('laporan_id');
        if (!$id) return redirect()->back()->with('error', 'ID laporan kosong');

        $rules = [
            'status' => 'required|in_list[pending,diproses,selesai]',
            'keterangan_verifikasi' => 'required|min_length[5]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal');
        }

        $this->laporanModel->update($id, [
            'status' => $this->request->getPost('status'),
            'tanggal_verifikasi' => date('Y-m-d H:i:s'),
            'verifikator' => session('nama'),
            'keterangan_verifikasi' => $this->request->getPost('keterangan_verifikasi')
        ]);

        return redirect()->back()->with('success', 'Verifikasi berhasil');
    }


    /* ============================================================
       HALAMAN DETAIL (OPSIONAL — MASIH DIPERLUKAN)
    ============================================================ */
    public function detail($id)
    {
        $laporan = $this->laporanModel->find($id);

        if (!$laporan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Laporan tidak ditemukan ID: ' . $id);
        }

        return view('admin/detail', [
            'title'   => 'Detail Laporan',
            'laporan' => $laporan,
        ]);
    }
}
