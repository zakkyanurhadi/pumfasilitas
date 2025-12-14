<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class ProfileController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        // Ambil data user yang sedang login dari database
        $user = $userModel->find(session()->get('user_id'));

        $data = [
            'title' => 'Edit Profil',
            'user'  => $user,
        ];

        return view('profile/index', $data);
    }

    public function update()
    {
        $userModel = new UserModel();
        $user = $userModel->find(session()->get('user_id'));
        $userId = $user['id'];

        // Aturan Validasi
        $rules = [
            'nama' => 'required|min_length[3]',
            // Pastikan email unik, tapi abaikan untuk user saat ini
            'email' => "required|valid_email|is_unique[users.email,id,{$userId}]",
            'avatar' => [
                'rules' => 'max_size[avatar,2048]|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png,image/gif]',
                'errors' => [
                    'max_size' => 'Ukuran file paling besar 2MB.',
                    'is_image' => 'File yang diupload harus berupa gambar.',
                    'mime_in'  => 'Format file yang diizinkan adalah JPG, GIF, atau PNG.',
                ],
            ],
        ];

        // Aturan validasi password (hanya jika diisi)
        if ($this->request->getPost('password')) {
            $rules['password'] = 'required|min_length[8]';
            $rules['pass_confirm'] = 'required|matches[password]';
        }

        if (!$this->validate($rules)) {
            // Jika validasi gagal, kembali ke form dengan error dan input lama
            return redirect()->to('/profile')->withInput()->with('errors', $this->validator->getErrors());
        }

        // --- Proses Upload Avatar ---
        $avatarFile = $this->request->getFile('avatar');
        $namaAvatar = $user['img']; // Gunakan nama avatar lama sebagai default

        // Jika ada file baru yang diupload dan valid
        if ($avatarFile->isValid() && !$avatarFile->hasMoved()) {
            // Hapus avatar lama jika bukan default.jpg
            if ($namaAvatar && $namaAvatar !== 'default.jpg') {
                $oldAvatarPath = FCPATH . 'uploads/avatars/' . $namaAvatar;
                if (file_exists($oldAvatarPath)) {
                    unlink($oldAvatarPath);
                }
            }
            // Pindahkan file baru ke folder public/uploads/avatars
            $namaAvatar = $avatarFile->getRandomName();
            $avatarFile->move(FCPATH . 'uploads/avatars', $namaAvatar);
        }

        // Siapkan data untuk diupdate ke database
        $dataToUpdate = [
            'nama'  => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'img'   => $namaAvatar,
        ];

        // Jika password diisi, hash dan tambahkan ke data update
        if ($this->request->getPost('password')) {
            $dataToUpdate['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        // Update data di database
        $userModel->update($userId, $dataToUpdate);

        // Perbarui data session agar nama dan GAMBAR di header juga berubah
        session()->set('nama', $dataToUpdate['nama']);
        if (isset($dataToUpdate['img'])) { // Jika ada gambar baru yang diupdate
            session()->set('img', $dataToUpdate['img']); // <-- TAMBAHKAN LOGIKA INI
        }

        // Redirect kembali ke halaman profil dengan pesan sukses
        return redirect()->to('/profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
