<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class ProfileDirekturController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        // Ambil data user yang sedang login dari database
        $user = $userModel->find(session()->get('user_id'));

        $data = [
            'title' => 'Profil Direktur',
            'user' => $user,
        ];

        return view('direktur/profile', $data);
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
                'rules' => 'max_size[avatar,2048]|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png,image/gif,image/webp]',
                'errors' => [
                    'max_size' => 'Ukuran file paling besar 2MB.',
                    'is_image' => 'File yang diupload harus berupa gambar.',
                    'mime_in' => 'Format file yang diizinkan adalah JPG, JPEG, PNG, GIF, atau WEBP.',
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
            return redirect()->to('/direktur/profile')->withInput()->with('errors', $this->validator->getErrors());
        }

        // --- Proses Upload Avatar ---
        $avatarFile = $this->request->getFile('avatar');
        $namaAvatar = $user['img'];

        if ($avatarFile && $avatarFile->isValid() && !$avatarFile->hasMoved()) {
            $targetPath = FCPATH . 'uploads/avatars';

            // Pastikan folder ada
            if (!is_dir($targetPath)) {
                mkdir($targetPath, 0777, true);
            }

            // Hapus avatar lama jika bukan default
            if ($namaAvatar && !in_array($namaAvatar, ['default.jpg', 'default.png', 'default.webp'])) {
                $oldAvatarPath = $targetPath . DIRECTORY_SEPARATOR . $namaAvatar;
                if (file_exists($oldAvatarPath)) {
                    @unlink($oldAvatarPath);
                }
            }

            // Coba konversi ke WebP jika method tersedia
            if (method_exists($this, 'convertImageToWebP')) {
                $webpName = $this->convertImageToWebP($avatarFile, $targetPath, 70);
                if ($webpName) {
                    $namaAvatar = $webpName;
                } else {
                    // Jika gagal konvert, simpan aslinya
                    $namaAvatar = $avatarFile->getRandomName();
                    $avatarFile->move($targetPath, $namaAvatar);
                }
            } else {
                $namaAvatar = $avatarFile->getRandomName();
                $avatarFile->move($targetPath, $namaAvatar);
            }
        }

        // Siapkan data untuk diupdate ke database
        $dataToUpdate = [
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'img' => $namaAvatar,
        ];

        // Jika password diisi, hash dan tambahkan ke data update
        if ($this->request->getPost('password')) {
            $dataToUpdate['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        // Update data di database
        $userModel->update($userId, $dataToUpdate);

        // Perbarui data session agar nama dan GAMBAR di header juga berubah
        session()->set('nama', $dataToUpdate['nama']);
        if (isset($dataToUpdate['img'])) {
            session()->set('img', $dataToUpdate['img']);
        }

        // Redirect kembali ke halaman profil dengan pesan sukses
        return redirect()->to('/direktur/profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
