<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LaporanModel;
use App\Models\GedungModel;
use App\Models\RuanganModel;

class LaporController extends BaseController
{
    protected $laporanModel;
    protected $gedungModel;
    protected $ruanganModel;

    public function __construct()
    {
        $this->laporanModel = new LaporanModel();
        $this->gedungModel = new GedungModel();
        $this->ruanganModel = new RuanganModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Buat Laporan Kerusakan',
            'gedung' => $this->gedungModel->findAll(),
            'ruangan' => $this->ruanganModel->findAll()
        ];

        return view('laporan/index', $data);
    }

    public function store()
    {
        // Cek apakah user sudah login (sesuai dengan AuthFilter)
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $rules = [
            'nama_pelapor'     => 'required|min_length[3]',
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

        // Handle upload foto
        $fotoName = null;
        $foto = $this->request->getFile('foto');

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            // Buat folder jika belum ada
            $uploadPath = FCPATH . 'uploads/laporan';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $fotoName = $foto->getRandomName();
            $foto->move($uploadPath, $fotoName);
        }

        // Ambil user_id dari session
        // Coba beberapa kemungkinan struktur session
        $userId = session()->get('user_id')
            ?? session()->get('id')
            ?? (is_array(session()->get('user')) ? session()->get('user')['id'] : null);

        // Jika user_id masih null, coba ambil dari session langsung
        if (!$userId) {
            // Debug: tampilkan semua isi session
            log_message('error', 'Session data: ' . print_r(session()->get(), true));

            session()->setFlashdata('error', 'Session tidak valid. Silakan login kembali');
            return redirect()->to('/login');
        }

        // Siapkan data untuk disimpan
        $data = [
            'nama_pelapor'     => $this->request->getPost('nama_pelapor'),
            'lokasi_kerusakan' => $this->request->getPost('lokasi_kerusakan'),
            'lokasi_spesifik'  => $this->request->getPost('lokasi_spesifik'),
            'deskripsi'        => $this->request->getPost('deskripsi'),
            'foto'             => $fotoName,
            'status'           => 'pending',
            'user_id'          => $userId,
            'gedung_id'        => $this->request->getPost('gedung_id'),
            'ruangan_id'       => $this->request->getPost('ruangan_id'),
            'prioritas'        => $this->request->getPost('prioritas'),
            'kategori'         => $this->request->getPost('kategori'),
        ];

        try {
            if ($this->laporanModel->insert($data)) {
                return redirect()->to('/laporan/saya')->with('success', 'Laporan berhasil dikirim');
            } else {
                $errors = $this->laporanModel->errors();
                log_message('error', 'Insert failed: ' . print_r($errors, true));
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan laporan');
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan laporan: ' . $e->getMessage());
        }
    }
    // Halaman Laporan Saya
    public function saya()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Ambil user_id dari session
        $userId = session()->get('user_id')
            ?? session()->get('id')
            ?? (is_array(session()->get('user')) ? session()->get('user')['id'] : null);

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Session tidak valid');
        }

        // Ambil filter
        $status = $this->request->getGet('status');
        $keyword = $this->request->getGet('keyword');

        // Query builder
        $builder = $this->laporanModel->where('user_id', $userId);

        // Filter status
        if ($status) {
            $builder->where('status', $status);
        }

        // Filter keyword
        if ($keyword) {
            $builder->groupStart()
                ->like('lokasi_kerusakan', $keyword)
                ->orLike('lokasi_spesifik', $keyword)
                ->orLike('kategori', $keyword)
                ->orLike('deskripsi', $keyword)
                ->groupEnd();
        }

        $perPage = 10;
        // Pagination
        $laporan = $builder
            ->orderBy('created_at', 'DESC')
            ->paginate($perPage, 'default');
        $pager = $this->laporanModel->pager;

        // Statistik
        $stats = $this->laporanModel
            ->select("
                COUNT(id) AS total,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) AS pending,
                SUM(CASE WHEN status = 'diproses' THEN 1 ELSE 0 END) AS diproses,
                SUM(CASE WHEN status = 'selesai' THEN 1 ELSE 0 END) AS selesai,
                SUM(CASE WHEN status = 'ditolak' THEN 1 ELSE 0 END) AS ditolak
            ")
            ->where('user_id', $userId)
            ->get()
            ->getRowArray();

        $data = [
            'title'       => 'Laporan Saya',
            'laporan'     => $laporan,
            'pager'   => $pager,
            'stats'       => $stats,
            'status'      => $status,
            'keyword'     => $keyword
        ];

        return view('laporan/saya', $data);
    }


    // Halaman Edit
    public function edit($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Ambil user_id
        $userId = session()->get('user_id')
            ?? session()->get('id')
            ?? (is_array(session()->get('user')) ? session()->get('user')['id'] : null);

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Session tidak valid');
        }

        // Ambil data laporan
        $laporan = $this->laporanModel->find($id);

        // Validasi
        if (!$laporan) {
            return redirect()->to('/laporan/saya')->with('error', 'Laporan tidak ditemukan');
        }

        // Cek kepemilikan
        if ($laporan['user_id'] != $userId) {
            return redirect()->to('/laporan/saya')->with('error', 'Anda tidak memiliki akses');
        }

        // Cek status - hanya pending dan ditolak yang bisa diedit
        if (!in_array($laporan['status'], ['pending', 'ditolak'])) {
            return redirect()->to('/laporan/saya')->with('error', 'Laporan tidak dapat diedit');
        }

        $data = [
            'title'   => 'Edit Laporan',
            'laporan' => $laporan,
            'gedung'  => $this->gedungModel->findAll(),
            'ruangan' => $this->ruanganModel->findAll()
        ];

        return view('laporan/edit', $data);
    }

    // Update Laporan
    public function update($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Ambil user_id
        $userId = session()->get('user_id')
            ?? session()->get('id')
            ?? (is_array(session()->get('user')) ? session()->get('user')['id'] : null);

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Session tidak valid');
        }

        // Ambil data laporan
        $laporan = $this->laporanModel->find($id);

        if (!$laporan || $laporan['user_id'] != $userId) {
            return redirect()->to('/laporan/saya')->with('error', 'Akses ditolak');
        }

        // Validasi
        $rules = [
            'nama_pelapor'     => 'required|min_length[3]',
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

        // Handle foto baru
        $fotoName = $laporan['foto']; // Gunakan foto lama
        $foto = $this->request->getFile('foto');

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            // Hapus foto lama jika ada
            if ($laporan['foto'] && file_exists(FCPATH . 'uploads/laporan/' . $laporan['foto'])) {
                unlink(FCPATH . 'uploads/laporan/' . $laporan['foto']);
            }

            // Upload foto baru
            $uploadPath = FCPATH . 'uploads/laporan';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $fotoName = $foto->getRandomName();
            $foto->move($uploadPath, $fotoName);
        }

        // Update data
        $data = [
            'nama_pelapor'     => $this->request->getPost('nama_pelapor'),
            'lokasi_kerusakan' => $this->request->getPost('lokasi_kerusakan'),
            'lokasi_spesifik'  => $this->request->getPost('lokasi_spesifik'),
            'deskripsi'        => $this->request->getPost('deskripsi'),
            'foto'             => $fotoName,
            'gedung_id'        => $this->request->getPost('gedung_id'),
            'ruangan_id'       => $this->request->getPost('ruangan_id'),
            'prioritas'        => $this->request->getPost('prioritas'),
            'kategori'         => $this->request->getPost('kategori'),
        ];

        if ($this->laporanModel->update($id, $data)) {
            return redirect()->to('/laporan/saya')->with('success', 'Laporan berhasil diupdate');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengupdate laporan');
        }
    }

    // Hapus Laporan
    public function delete($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Ambil user_id
        $userId = session()->get('user_id')
            ?? session()->get('id')
            ?? (is_array(session()->get('user')) ? session()->get('user')['id'] : null);

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Session tidak valid');
        }

        // Ambil data laporan
        $laporan = $this->laporanModel->find($id);

        // Validasi
        if (!$laporan) {
            return redirect()->to('/laporan/saya')->with('error', 'Laporan tidak ditemukan');
        }

        // Cek kepemilikan
        if ($laporan['user_id'] != $userId) {
            return redirect()->to('/laporan/saya')->with('error', 'Anda tidak memiliki akses');
        }

        // Cek status - hanya pending dan ditolak yang bisa dihapus
        if (!in_array($laporan['status'], ['pending', 'ditolak'])) {
            return redirect()->to('/laporan/saya')->with('error', 'Laporan tidak dapat dihapus');
        }

        // Hapus foto jika ada
        if ($laporan['foto'] && file_exists(FCPATH . 'uploads/laporan/' . $laporan['foto'])) {
            unlink(FCPATH . 'uploads/laporan/' . $laporan['foto']);
        }

        // Hapus laporan
        if ($this->laporanModel->delete($id)) {
            return redirect()->to('/laporan/saya')->with('success', 'Laporan berhasil dihapus');
        } else {
            return redirect()->to('/laporan/saya')->with('error', 'Gagal menghapus laporan');
        }
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

        // ✅ FILTER UTAMA
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
