<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = \Config\Services::session();
        helper(['form', 'url']);
    }

    public function index()
    {
        // Jika sudah login, redirect ke dashboard
        if ($this->session->get('isLoggedIn')) {
            return redirect()->to('dashboard');
        }
        // Ganti 'auth/login' menjadi nama view Anda, misalnya 'login_view'
        return view('auth/login_view');
    }

public function login()
{
    // Validasi input
    $validation = \Config\Services::validation();
    $rules = [
        'login_identifier' => ['rules' => 'required', 'errors' => ['required' => 'NPM atau Email harus diisi.']],
        'password' => ['rules' => 'required', 'errors' => ['required' => 'Password tidak boleh kosong.']]
    ];

    if (!$this->validate($rules)) {
        $errors = $validation->getErrors();
        return $this->response->setJSON(['success' => false, 'message' => reset($errors)]);
    }

    $identifier = $this->request->getPost('login_identifier');
    $password = $this->request->getPost('password');

    // Cari user berdasarkan NPM atau Email
    $user = $this->userModel
        ->where('npm', $identifier)
        ->orWhere('email', $identifier)
        ->first();

    if (!$user || !password_verify($password, $user['password'])) {
        return $this->response->setJSON(['success' => false, 'message' => 'NPM/Email atau Password salah.']);
    }

    // Simpan session
    $sessionData = [
        'user_id'    => $user['id'],
        'npm'        => $user['npm'],
        'nama'       => $user['nama'],
        'email'      => $user['email'],
        'img'        => $user['img'],
        'role'       => $user['role'],         // Tambahkan role ke session
        'isLoggedIn' => true
    ];
    $this->session->set($sessionData);

    // Redirect URL sesuai role
    $redirectUrl = ($user['role'] === 'admin') ? base_url('/dashboardadmin') : base_url('/dashboard');

    return $this->response->setJSON([
        'success' => true,
        'message' => 'Login berhasil!',
        'redirect' => $redirectUrl
    ]);
}


    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('login');
    }

    public function forgotPassword()
    {
        $rules = ['email' => 'required|valid_email'];
        if (!$this->validate($rules)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Format email tidak valid.']);
        }

        $email = $this->request->getPost('email');
        $user = $this->userModel->where('email', $email)->first();

        // Untuk keamanan, selalu berikan pesan sukses meskipun email tidak ditemukan.
        if (!$user) {
            return $this->response->setJSON(['success' => true, 'message' => 'Jika email terdaftar, link reset telah dikirim.']);
        }

        // TODO: Logika untuk generate token dan kirim email
        // $resetToken = bin2hex(random_bytes(32));
        // Simpan token dan kirim email...

        return $this->response->setJSON(['success' => true, 'message' => 'Link reset telah dikirim ke ' . $email]);
    }
}
