<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AdminAkunController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();
        $pager = \Config\Services::pager();
        $perPage = 10;

        // Ambil segment URL
        $uri = service('uri')->getSegment(1);

        // Pemisahan halaman berdasarkan role
        $roleMapper = [
            'akunadmin' => 'admin',
            'akunuser'  => 'user'
        ];

        $roleFilter = $roleMapper[$uri] ?? '';

        // GET keyword
        $keyword = $this->request->getGet('keyword');
        $currentPage = $this->request->getGet('page') ?? 1;

        $builder = $db->table('users');

        // Filter role berdasarkan halaman
        if ($roleFilter != '') {
            $builder->where('role', $roleFilter);
        }

        // Search
        if ($keyword) {
            $builder->groupStart()
                ->like('nama', $keyword)
                ->orLike('email', $keyword)
                ->orLike('npm', $keyword)
                ->groupEnd();
        }

        $builder->orderBy('created_at', 'DESC');

        // Count & Pagination
        $total = $builder->countAllResults(false);
        $users = $builder->get($perPage, ($currentPage - 1) * $perPage)->getResultArray();

        $pager_links = $pager->makeLinks(
            $currentPage,
            $perPage,
            $total,
            'default_full',
            0,
            '',
            $this->request->getGet()
        );

        return view('admin/akun', [
            'title'        => 'Manajemen Akun',
            'users'        => $users,
            'pager_links'  => $pager_links,
            'keyword'      => $keyword,
            'roleFilter'   => $roleFilter,
            'currentPage'  => $currentPage,
            'perPage'      => $perPage,
            'uri'          => $uri
        ]);
    }
    
    public function store()
    {
        $data = [
            'npm'      => $this->request->getPost('npm'),
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash('123456', PASSWORD_DEFAULT), // password default
            'role'     => $this->request->getPost('role'),
            'status'   => $this->request->getPost('status') ?? 'active'
        ];

        $this->userModel->insert($data);

        return redirect()->back()->with('success', 'Akun berhasil ditambahkan.');
    }

    /** Delete User */
    public function delete($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) return redirect()->back()->with('error', 'User tidak ditemukan!');

        $this->userModel->delete($id);

        return redirect()->back()->with('success', 'Akun berhasil dihapus.');
    }
    


    /** Edit User (simple update nama/email) */
    public function update()
    {
        $id = $this->request->getPost('id');

        if (!$id) return redirect()->back()->with('error', 'ID tidak valid');

        $data = [
            'nama'  => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'status' => $this->request->getPost('status')
        ];

        $this->userModel->update($id, $data);

        return redirect()->back()->with('success', 'Akun berhasil diperbarui.');
    }
}
