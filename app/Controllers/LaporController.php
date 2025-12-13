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

    /* =======================================================
       HALAMAN LAPORAN (Pending + Diproses)
    ======================================================= */
    public function index()
    {
        $db     = \Config\Database::connect();
        $pager  = \Config\Services::pager();
        $perPage = 10;

        $builder = $db->table('laporan');

        // Status berdasarkan route
        $uri = service('uri')->getSegment(1);

        if ($uri == 'laporanadminpending') {
            $builder->where('status', 'pending');
        }

        if ($uri == 'laporanadmindiproses') {
            $builder->where('status', 'diproses');
        }

        // GET PARAMETER
        $keyword = $this->request->getGet('keyword');
        $currentPage = $this->request->getGet('page') ?? 1;

        // SEARCH
        if ($keyword) {
            $builder->groupStart()
                ->like('lokasi_kerusakan', $keyword)
                ->orLike('kategori', $keyword)
                ->orLike('nama_pelapor', $keyword)
                ->groupEnd();
        }

        // ORDER
        $builder->orderBy('created_at', 'DESC');

        // PAGINATION
        $total = $builder->countAllResults(false);
        $laporan = $builder->get($perPage, ($currentPage - 1) * $perPage)->getResultArray();
        $pager_links = $pager->makeLinks($currentPage, $perPage, $total, 'default_full');

        // GET DETAIL
        $detail = null;
        $detailId = $this->request->getGet('detail');

        if ($detailId) {
            $detail = $db->table('laporan')->where('id', $detailId)->get()->getRowArray();
        }

        return view('admin/laporan', [
            'title'   => 'Daftar Laporan',
            'laporan' => $laporan,
            'pager_links' => $pager_links,
            'keyword' => $keyword,
            'currentPage' => $currentPage,
            'perPage' => $perPage,
            'detail' => $detail,
            'uri' => $uri
        ]);
    }


    /* =======================================================
       RIWAYAT LAPORAN SELESAI
    ======================================================= */
    public function riwayat()
    {
        $db = \Config\Database::connect();
        $pager = \Config\Services::pager();
        $perPage = 8;

        $builder = $db->table('laporan')->where('status', 'selesai');

        // SEARCH
        $keyword = $this->request->getGet('keyword');
        $currentPage = $this->request->getGet('page') ?? 1;

        if ($keyword) {
            $builder->groupStart()
                ->like('lokasi_kerusakan', $keyword)
                ->orLike('kategori', $keyword)
                ->orLike('nama_pelapor', $keyword)
                ->groupEnd();
        }

        $builder->orderBy('updated_at', 'DESC');

        // PAGINATION
        $total = $builder->countAllResults(false);
        $laporan = $builder->get($perPage, ($currentPage - 1) * $perPage)->getResultArray();
        $pager_links = $pager->makeLinks($currentPage, $perPage, $total, 'default_full');

        // DETAIL
        $detail = null;
        if ($this->request->getGet('detail')) {
            $detail = $db->table('laporan')
                ->where('id', $this->request->getGet('detail'))
                ->get()
                ->getRowArray();
        }

        return view('admin/laporan', [
            'title' => 'Riwayat Laporan Selesai',
            'laporan' => $laporan,
            'pager_links' => $pager_links,
            'keyword' => $keyword,
            'currentPage' => $currentPage,
            'perPage' => $perPage,
            'detail' => $detail,
            'uri' => 'riwayatadmin'
        ]);
    }


    /* =======================================================
       VERIFIKASI
    ======================================================= */
    public function verifikasi()
    {
        $id = $this->request->getPost('laporan_id');
        if (!$id) return redirect()->back()->with('error', 'ID laporan kosong.');

        $rules = [
            'status' => 'required|in_list[pending,diproses,selesai]',
            'keterangan_verifikasi' => 'required|min_length[5]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $this->laporanModel->update($id, [
            'status' => $this->request->getPost('status'),
            'keterangan_verifikasi' => $this->request->getPost('keterangan_verifikasi'),
            'tanggal_verifikasi' => date('Y-m-d H:i:s'),
            'admin_verifikator' => session()->get('nama'),
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil diverifikasi.');
    }


    /* =======================================================
       DETAIL
    ======================================================= */
    public function detail($id)
    {
        $laporan = $this->laporanModel->find($id);
        if (!$laporan) throw new \CodeIgniter\Exceptions\PageNotFoundException();

        return view('admin/detail', [
            'title'   => 'Detail Laporan',
            'laporan' => $laporan
        ]);
    }
}
