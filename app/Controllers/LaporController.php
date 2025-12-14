<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LaporanModel;
use App\Models\GedungModel;
use App\Models\RuanganModel;

class LaporController extends BaseController
{
    protected $laporanModel;

    public function __construct()
    {
        $this->laporanModel = new LaporanModel();
    }

    /* =========================
       CREATE FORM
    ========================= */
    public function index()
    {
        return view('laporan/index', [
            'title'   => 'Buat Laporan',
            'laporan' => null, // penting untuk edit/create satu form
            'gedung'  => (new GedungModel())->findAll(),
            'ruangan' => (new RuanganModel())->findAll(),
        ]);
    }

    /* =========================
       STORE (CREATE)
    ========================= */
    public function store()
    {
        $rules = [
            'lokasi_kerusakan' => 'required',
            'lokasi_spesifik'  => 'required',
            'gedung_id'        => 'required|is_not_unique[gedung.id]',
            'ruangan_id'       => 'required|is_not_unique[ruangan.id]',
            'kategori'         => 'required',
            'prioritas'        => 'required|in_list[low,medium,high]',
            'deskripsi'        => 'required|min_length[5]',
            'foto'             => 'permit_empty|max_size[foto,2048]|is_image[foto]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fotoName = null;
        $foto = $this->request->getFile('foto');

        if ($foto && $foto->isValid()) {
            $fotoName = $foto->getRandomName();
            $foto->move(FCPATH . 'uploads/laporan', $fotoName);
        }

        $user = session()->get('user');

        $this->laporanModel->insert([
            'nama_pelapor'     => $user['nama'],
            'lokasi_kerusakan' => $this->request->getPost('lokasi_kerusakan'),
            'lokasi_spesifik'  => $this->request->getPost('lokasi_spesifik'),
            'deskripsi'        => $this->request->getPost('deskripsi'),
            'foto'             => $fotoName,
            'status'           => 'pending',
            'user_id'          => $user['id'],
            'gedung_id'        => $this->request->getPost('gedung_id'),
            'ruangan_id'       => $this->request->getPost('ruangan_id'),
            'prioritas'        => $this->request->getPost('prioritas'),
            'kategori'         => $this->request->getPost('kategori'),
        ]);

        return redirect()->to('/laporan')->with('success', 'Laporan berhasil dikirim');
    }

    /* =========================
       EDIT FORM (PAKAI FORM YANG SAMA)
    ========================= */
    // EDIT
    public function edit($id)
    {
        $laporan = $this->laporanModel->find($id);
        $userId  = session()->get('user_id');

        if (!$laporan || $laporan['user_id'] != $userId || $laporan['status'] !== 'pending') {
            return redirect()->to('/laporan/saya');
        }

        return view('laporan/index', [
            'title'   => 'Edit Laporan',
            'laporan' => $laporan,
            'gedung'  => (new GedungModel())->findAll(),
            'ruangan' => (new RuanganModel())->findAll(),
        ]);
    }

    // DELETE
    public function delete($id)
    {
        $laporan = $this->laporanModel->find($id);
        $userId  = session()->get('user_id');

        if (!$laporan || $laporan['user_id'] != $userId || $laporan['status'] !== 'pending') {
            return redirect()->to('/laporan/saya');
        }

        if ($laporan['foto']) {
            @unlink(FCPATH . 'uploads/laporan/' . $laporan['foto']);
        }

        $this->laporanModel->delete($id);

        return redirect()->to('/laporan/saya')
            ->with('success', 'Laporan berhasil dihapus');
    }




    public function status()
    {
        $db    = \Config\Database::connect();
        $pager = \Config\Services::pager();
        $perPage = 5;

        // 🔐 Ambil user login
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login');
        }

        // Filter input
        $keyword = $this->request->getGet('keyword') ?? '';
        $status  = $this->request->getGet('status') ?? '';

        // Query builder + JOIN
        $builder = $db->table('laporan')
            ->select('
            laporan.*,
            gedung.nama AS nama_gedung,
            ruangan.nama_ruangan
        ')
            ->join('gedung', 'gedung.id = laporan.gedung_id', 'left')
            ->join('ruangan', 'ruangan.id = laporan.ruangan_id', 'left')
            ->where('laporan.user_id', $userId);

        // 🔍 Search
        if ($keyword) {
            $builder->groupStart()
                ->like('laporan.lokasi_kerusakan', $keyword)
                ->orLike('laporan.lokasi_spesifik', $keyword)
                ->orLike('laporan.kategori', $keyword)
                ->orLike('gedung.nama', $keyword)
                ->orLike('ruangan.nama_ruangan', $keyword)
                ->groupEnd();
        }

        // 🎯 Filter status
        if ($status && in_array($status, ['pending', 'diproses'])) {
            $builder->where('laporan.status', $status);
        } else {
            // Default: belum selesai
            $builder->whereIn('laporan.status', ['pending', 'diproses']);
        }

        // ⏱️ Urut terbaru
        $builder->orderBy('laporan.created_at', 'DESC');

        // Pagination
        $currentPage = $this->request->getGet('page') ?? 1;
        $total       = $builder->countAllResults(false);
        $laporan     = $builder->get($perPage, ($currentPage - 1) * $perPage)
            ->getResultArray();

        $pager_links = $pager->makeLinks($currentPage, $perPage, $total, 'default_full');

        return view('laporan/saya', [
            'title'       => 'Laporan Saya',
            'laporan'     => $laporan,
            'pager_links' => $pager_links,
            'keyword'     => $keyword,
            'status'      => $status,
        ]);
    }


    /* =========================
       DETAIL
    ========================= */
    public function detail($id)
    {
        $db = \Config\Database::connect();

        // 🔐 Cek login
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login');
        }

        // 📌 Ambil laporan + join gedung & ruangan
        $laporan = $db->table('laporan l')
            ->select('
            l.*,
            g.nama AS nama_gedung,
            r.nama_ruangan
        ')
            ->join('gedung g', 'g.id = l.gedung_id', 'left')
            ->join('ruangan r', 'r.id = l.ruangan_id', 'left')
            ->where('l.id', $id)
            ->get()
            ->getRowArray();

        if (!$laporan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Laporan tidak ditemukan');
        }

        // 🔒 Hak akses: hanya pemilik laporan atau admin
        $role = session()->get('role') ?? 'user';
        if ($laporan['user_id'] != $userId && !in_array($role, ['admin', 'staff'])) {
            return redirect()->to('/laporan')
                ->with('error', 'Anda tidak memiliki akses ke laporan ini.');
        }

        return view('laporan/detail', [
            'title'   => 'Detail Laporan',
            'laporan' => $laporan,
        ]);
    }

    public function riwayat()
    {
        $perPage = 5;
        $keyword = $this->request->getGet('keyword');

        $model = new LaporanModel();

        // Filter utama: hanya laporan selesai
        $model->where('status', 'selesai');

        // Pencarian
        if (!empty($keyword)) {
            $model->groupStart()
                ->like('lokasi_kerusakan', $keyword)
                ->orLike('kategori', $keyword)
                ->orLike('nama_pelapor', $keyword)
                ->groupEnd();
        }

        // Pagination CI4 Native
        $laporan = $model
            ->orderBy('updated_at', 'DESC')
            ->paginate($perPage, 'default');

        return view('laporan/riwayat', [
            'title'   => 'Riwayat Laporan Selesai',
            'laporan' => $laporan,
            'pager'   => $model->pager,
            'keyword' => $keyword,
        ]);
    }
}
