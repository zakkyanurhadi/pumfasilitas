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
            'gedung'       => $gedung,
            'pager_links'  => $this->gedungModel->pager->links(),
            'keyword'      => $keyword,
            'currentPage'  => $currentPage,
            'perPage'      => $perPage
        ]);
    }

    /* ==========================================================
       TAMBAH GEDUNG
    ========================================================== */
    public function store()
    {
        $data = [
            'kode'      => $this->request->getPost('kode'),
            'nama'      => $this->request->getPost('nama'),
            'deskripsi' => $this->request->getPost('deskripsi')
        ];

        $this->gedungModel->insert($data);

        return redirect()->back()->with('success', 'Gedung berhasil ditambahkan.');
    }

    /* ==========================================================
       UPDATE GEDUNG
    ========================================================== */
    public function update()
    {
        $id = $this->request->getPost('id');

        if (!$id) return redirect()->back()->with('error', 'ID tidak valid');

        $data = [
            'kode'      => $this->request->getPost('kode'),
            'nama'      => $this->request->getPost('nama'),
            'deskripsi' => $this->request->getPost('deskripsi')
        ];

        $this->gedungModel->update($id, $data);

        return redirect()->back()->with('success', 'Gedung berhasil diperbarui.');
    }

    /* ==========================================================
       HAPUS GEDUNG
    ========================================================== */
    public function delete($id)
    {
        $gedung = $this->gedungModel->find($id);
        if (!$gedung) return redirect()->back()->with('error', 'Gedung tidak ditemukan!');

        $this->gedungModel->delete($id);

        return redirect()->back()->with('success', 'Gedung berhasil dihapus.');
    }
}
