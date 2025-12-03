<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LaporanModel;

class LaporController extends BaseController
{
    /**
     * Menampilkan halaman form untuk membuat laporan baru.
     */
    public function index()
    {
        $data = [
            'title' => 'Buat Laporan Baru',
        ];
        return view('laporan/index', $data);
    }
    /**
     * Menyimpan data laporan baru dari form.
     */
    public function store()
    {
        // Aturan validasi
        $rules = [
            'nama'           => 'required|min_length[3]',
            'npm'            => 'required|exact_length[8]',
            'lokasi'         => 'required',
            'lokasiSpesifik' => 'required',
            'kategori'       => 'required',
            'prioritas'      => 'required',
            'deskripsi'      => 'required|min_length[1]',
            'foto.*'         => 'max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/gif]',
        ];
        if (!$this->validate($rules)) {
            // Jika validasi gagal, kembali ke form dengan error
            return redirect()->to('/dashboard')->withInput()->with('errors', $this->validator->getErrors());
        }

        // Proses upload file jika ada
        $imageFiles = $this->request->getFiles('foto');
        $uploadedImageNames = [];

        if ($imageFiles) {
            foreach ($imageFiles['foto'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move(FCPATH . 'uploads/laporan', $newName);
                    $uploadedImageNames[] = $newName;
                }
            }
        }

        // Siapkan data untuk disimpan ke database
        $laporanModel = new LaporanModel();
        $dataToSave = [
            'nama'                => $this->request->getPost('nama'),
            'npm'                 => $this->request->getPost('npm'),
            'lokasi_kerusakan'    => $this->request->getPost('lokasi'),
            'lokasi_spesifik'     => $this->request->getPost('lokasiSpesifik'),
            'kategori_kerusakan'  => $this->request->getPost('kategori'),
            'tingkat_prioritas'   => $this->request->getPost('prioritas'),
            'deskripsi_kerusakan' => $this->request->getPost('deskripsi'),
            'foto_kerusakan'      => json_encode($uploadedImageNames), // Simpan sebagai JSON
            'status'              => 'Pending', // Status default
        ];

        // Simpan data
        $laporanModel->save($dataToSave);

        // Redirect ke dashboard dengan pesan sukses
        return redirect()->to('/dashboard')->with('success', 'Laporan Anda telah berhasil dikirim!');
    }

    // app/Controllers/LaporController.php

    public function status()
    {
        // 1. Panggil service database & pager secara langsung
        $db    = \Config\Database::connect();
        $pager = \Config\Services::pager();
        $perPage = 5; // Jumlah item per halaman

        // 2. Ambil input dari URL untuk filter & pencarian
        $keyword = $this->request->getGet('keyword') ?? '';
        $status  = $this->request->getGet('status') ?? '';

        // 3. Buat instance Query Builder untuk tabel 'laporan'
        $builder = $db->table('laporan');

        // 4. Terapkan filter & pencarian (logika dari model dipindahkan ke sini)
        if ($keyword) {
            $builder->groupStart();
            $builder->like('nama', $keyword);
            $builder->orLike('npm', $keyword);
            $builder->orLike('lokasi_kerusakan', $keyword);
            $builder->orLike('lokasi_spesifik', $keyword);
            $builder->orLike('kategori_kerusakan', 'keyword');
            $builder->groupEnd();
        }
        // --- PERUBAHAN LOGIKA FILTER STATUS ---
        if ($status && in_array($status, ['Pending', 'Diproses'])) {
            // Jika user memfilter status tertentu ('Pending' atau 'Diproses')
            $builder->where('status', $status);
        } else {
            // Jika tidak ada filter, secara default tampilkan Pending DAN Diproses
            $builder->whereIn('status', ['Pending', 'Diproses']);
        }


        // 5. Terapkan pengurutan (dari yang terbaru ke terlama)
        $builder->orderBy('created_at', 'ASC');

        // 6. Logika Pagination Manual
        // Dapatkan halaman saat ini dari URL (misal: ?page=2)
        $currentPage = $this->request->getGet('page') ? (int) $this->request->getGet('page') : 1;

        // Hitung total baris data yang cocok dengan kriteria filter (PENTING: parameter false agar tidak mereset query)
        $total = $builder->countAllResults(false);

        // Dapatkan data untuk halaman saat ini
        $laporan = $builder->get($perPage, ($currentPage - 1) * $perPage)->getResultArray();

        // Buat link navigasi halaman
        $pager_links = $pager->makeLinks($currentPage, $perPage, $total, 'default_full');

        // 7. Siapkan data untuk dikirim ke view
        $data = [
            'title'       => 'Status Laporan',
            'laporan'     => $laporan,
            'pager_links' => $pager_links, // Kirim link HTML pager
            'keyword'     => $keyword,
            'status'      => $status,
            'currentPage' => $currentPage,
            'perPage'     => $perPage,
        ];

        return view('laporan/status', $data);
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

        return view('laporan/detail', $data);
    }


    // app/Controllers/LaporController.php

    // ... (tambahkan method ini di dalam class LaporController)

    public function riwayat()
    {
        $db    = \Config\Database::connect();
        $pager = \Config\Services::pager();
        $perPage = 5; // Tampilkan 10 riwayat per halaman

        $builder = $db->table('laporan');

        // Filter UTAMA: Hanya tampilkan yang statusnya 'Selesai'
        $builder->where('status', 'Selesai');

        // Tambahkan fungsionalitas pencarian jika ada keyword
        if ($keyword = $this->request->getGet('keyword')) {
            $builder->groupStart();
            $builder->like('lokasi_kerusakan', $keyword);
            $builder->orLike('kategori_kerusakan', $keyword);
            $builder->orLike('nama', $keyword);
            $builder->groupEnd();
        }

        // Urutkan berdasarkan kapan laporan diselesaikan (updated_at)
        $builder->orderBy('updated_at', 'ASC');

        // Logika Pagination
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

        return view('laporan/riwayat', $data);
    }
}
