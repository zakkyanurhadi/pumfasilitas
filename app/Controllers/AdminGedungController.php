<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GedungModel;

class AdminGedungController extends BaseController
{
    protected $gedungModel;

    public function __construct()
    {
        $this->gedungModel = new GedungModel();
    }

    /* ==========================================================
       HALAMAN KELOLA GEDUNG
    ========================================================== */
    public function index()
    {
        // 🔒 Cek hanya Super Admin
        if (session()->get('role') != 'superadmin') {
            return redirect()->to('/dashboardadmin');
        }

        $keyword = $this->request->getGet('keyword');
        $currentPage = $this->request->getGet('page') ?? 1;
        $perPage = 10;

        $builder = $this->gedungModel;

        if ($keyword) {
            $builder->groupStart()
                ->like('kode', $keyword)
                ->orLike('nama', $keyword)
                ->orLike('deskripsi', $keyword)
                ->groupEnd();
        }

        $gedung = $builder->orderBy('created_at', 'DESC')
            ->paginate($perPage);

        return view('admin/gedung', [
            'gedung' => $gedung,
            'pager_links' => $this->gedungModel->pager->links(),
            'keyword' => $keyword,
            'currentPage' => $currentPage,
            'perPage' => $perPage
        ]);
    }

    /* ==========================================================
       TAMBAH GEDUNG
    ========================================================== */
    public function store()
    {
        $kode = $this->request->getPost('kode');
        $nama = $this->request->getPost('nama');
        $deskripsi = $this->request->getPost('deskripsi');

        // Validasi input required
        if (empty($kode) || empty($nama)) {
            return redirect()->back()->withInput()->with('error', 'Kode dan Nama Gedung wajib diisi!');
        }

        // Cek duplikat kode gedung
        $existingKode = $this->gedungModel->where('kode', $kode)->first();
        if ($existingKode) {
            return redirect()->back()->withInput()->with('error', "Kode gedung '$kode' sudah digunakan. Silakan gunakan kode lain.");
        }

        $data = [
            'kode' => $kode,
            'nama' => $nama,
            'deskripsi' => $deskripsi
        ];

        if ($this->gedungModel->insert($data)) {
            // Log Aktivitas
            $logModel = new \App\Models\LogAktivitasModel();
            $adminId = session()->get('user_id');
            $logModel->catat($adminId, "Menambah gedung: {$data['nama']} ({$data['kode']})");
            return redirect()->back()->with('success', 'Gedung berhasil ditambahkan.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan gedung.');
        }
    }

    /* ==========================================================
       UPDATE GEDUNG
    ========================================================== */
    public function update()
    {
        $id = $this->request->getPost('id');
        $kode = $this->request->getPost('kode');
        $nama = $this->request->getPost('nama');
        $deskripsi = $this->request->getPost('deskripsi');

        if (!$id) {
            return redirect()->back()->with('error', 'ID tidak valid');
        }

        // Validasi input required
        if (empty($kode) || empty($nama)) {
            return redirect()->back()->withInput()->with('error', 'Kode dan Nama Gedung wajib diisi!');
        }

        // Cek duplikat kode gedung (kecuali gedung ini sendiri)
        $existingKode = $this->gedungModel->where('kode', $kode)->where('id !=', $id)->first();
        if ($existingKode) {
            return redirect()->back()->withInput()->with('error', "Kode gedung '$kode' sudah digunakan oleh gedung lain.");
        }

        $data = [
            'kode' => $kode,
            'nama' => $nama,
            'deskripsi' => $deskripsi
        ];

        if ($this->gedungModel->update($id, $data)) {
            // Log Aktivitas
            $logModel = new \App\Models\LogAktivitasModel();
            $adminId = session()->get('user_id');
            $dataLog = "Memperbarui gedung (ID: $id): {$data['nama']} ({$data['kode']})";
            $logModel->catat($adminId, $dataLog);
            return redirect()->back()->with('success', 'Gedung berhasil diperbarui.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui gedung.');
        }
    }

    /* ==========================================================
       HAPUS GEDUNG
    ========================================================== */
    public function delete($id)
    {
        $gedung = $this->gedungModel->find($id);
        if (!$gedung)
            return redirect()->back()->with('error', 'Gedung tidak ditemukan!');

        if ($this->gedungModel->delete($id)) {
            // Log Aktivitas
            $logModel = new \App\Models\LogAktivitasModel();
            $adminId = session()->get('user_id');
            $logModel->catat($adminId, "Menghapus gedung: {$gedung['nama']}");
        }

        return redirect()->back()->with('success', 'Gedung berhasil dihapus.');
    }
}
