<?php

namespace App\Controllers;

use App\Models\LaporanModel;
use CodeIgniter\Controller;

class AdminLaporController extends BaseController
{
    protected $laporanModel;

    public function __construct()
    {
        $this->laporanModel = new LaporanModel();
    }

    public function index()
    {
        $data = [
            'laporan' => $this->laporanModel->paginate(10),
            'pager_links' => $this->laporanModel->pager->links(),
        ];

        return view('admin/laporan', $data);
    }

    public function riwayat()
    {
        $db    = \Config\Database::connect();
        $pager = \Config\Services::pager();
        $perPage = 5;

        $builder = $db->table('laporan');
        $builder->where('status', 'Selesai');

        if ($keyword = $this->request->getGet('keyword')) {
            $builder->groupStart();
            $builder->like('lokasi_kerusakan', $keyword);
            $builder->orLike('kategori_kerusakan', $keyword);
            $builder->orLike('nama', $keyword);
            $builder->groupEnd();
        }

        $builder->orderBy('updated_at', 'ASC');
        $currentPage = $this->request->getGet('page') ?? 1;
        $total = $builder->countAllResults(false);
        $laporan = $builder->get($perPage, ($currentPage - 1) * $perPage)->getResultArray();
        $pager_links = $pager->makeLinks($currentPage, $perPage, $total, 'default_full');

        $data = [
            'title'       => 'Riwayat Laporan Selesai',
            'laporan'     => $laporan,
            'pager_links' => $pager_links,
            'keyword'     => $keyword,
            'currentPage' => $currentPage,
            'perPage'     => $perPage,
        ];

        return view('admin/riwayat', $data);
    }

    public function verifikasiForm($id)
    {
        $laporan = $this->laporanModel->find($id);
        if (!$laporan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('admin/laporan', ['laporan' => $laporan]);
    }

public function verifikasi()
{
    $laporanModel = new LaporanModel();

    // Ambil ID dari input
    $id = $this->request->getPost('laporan_id');
    if (!$id) {
    return redirect()->back()->with('error', 'ID laporan kosong.');
    }

    // Validasi data input
    $rules = [
        'status' => 'required|in_list[Pending,Diproses,Selesai]',
        'keterangan_verifikasi' => 'required|min_length[5]',
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    // Pastikan laporan ada
    $laporan = $laporanModel->find($id);
    if (!$laporan) {
        return redirect()->back()->with('error', 'Laporan tidak ditemukan.');
    }

    // Update laporan
    $laporanModel->update($id, [
        'status' => $this->request->getPost('status'),
        'tanggal_verifikasi' => date('Y-m-d H:i:s'),
        'verifikator' => session()->get('nama'),
        'keterangan_verifikasi' => $this->request->getPost('keterangan_verifikasi'),
    ]);

    return redirect()->to('/laporanadmin')->with('success', 'Laporan berhasil diverifikasi.');
}




        public function detail($id)
    {
        $laporanModel = new LaporanModel();
        $laporan = $laporanModel->find($id);

        // Jika data laporan tidak ditemukan, tampilkan halaman error 404
        if (!$laporan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Laporan tidak ditemukan dengan ID: ' . $id);
        }

        $data = [
            'title'   => 'Detail Laporan',
            'laporan' => $laporan,
        ];

        return view('lapor/detail', $data);
    }
}
