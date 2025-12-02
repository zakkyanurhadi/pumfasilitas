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

    // =========================================================================
    // 1. HALAMAN LOGIN
    // =========================================================================
    public function index()
    {
        // Jika sudah login, redirect ke dashboard yang sesuai
        if ($this->session->get('isLoggedIn')) {
            $role = $this->session->get('role');
            return redirect()->to($role === 'admin' ? 'dashboardadmin' : 'dashboard');
        }
        
        // Tampilkan view login
        return view('auth/login_view');
    }

    // =========================================================================
    // 2. PROSES LOGIN (AJAX)
    // =========================================================================
    public function login()
    {
        $validation = \Config\Services::validation();

        // Aturan validasi login
        $rules = [
            'login_identifier' => [
                'rules' => 'required',
                'errors' => ['required' => 'NPM atau Email harus diisi.']
            ],
            'password' => [
                'rules' => 'required',
                'errors' => ['required' => 'Password tidak boleh kosong.']
            ]
        ];

        if (!$this->validate($rules)) {
            $errors = $validation->getErrors();
            return $this->response->setJSON(['success' => false, 'message' => reset($errors)]);
        }

        $identifier = $this->request->getPost('login_identifier');
        $password = $this->request->getPost('password');

        // Cari user di database (bisa pakai NPM atau Email)
        $user = $this->userModel
            ->where('npm', $identifier)
            ->orWhere('email', $identifier)
            ->first();

        // Verifikasi User dan Password
        if (!$user || !password_verify($password, $user['password'])) {
            return $this->response->setJSON(['success' => false, 'message' => 'NPM/Email atau Password salah.']);
        }

        // Set Session Data
        $sessionData = [
            'user_id'    => $user['id'],
            'npm'        => $user['npm'],
            'nama'       => $user['nama'],
            'email'      => $user['email'],
            'img'        => $user['img'],
            'role'       => $user['role'],
            'isLoggedIn' => true
        ];
        $this->session->set($sessionData);

        // Tentukan Redirect URL berdasarkan Role
        $redirectUrl = ($user['role'] === 'admin') ? base_url('/dashboardadmin') : base_url('/dashboard');

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Login berhasil! Mengalihkan...',
            'redirect' => $redirectUrl
        ]);
    }

    // =========================================================================
    // 3. HALAMAN REGISTER
    // =========================================================================
    public function register()
    {
        // Jika sudah login, lempar ke dashboard
        if ($this->session->get('isLoggedIn')) {
            return redirect()->to('dashboard');
        }
        
        // Tampilkan view register
        return view('auth/register');
    }

    // =========================================================================
    // 4. PROSES REGISTER (Otomatis Role Mahasiswa)
    // =========================================================================
    public function processRegister()
    {
        $validation = \Config\Services::validation();

        // Aturan Validasi Input
        $rules = [
            'fullname' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'Nama lengkap wajib diisi.',
                    'min_length' => 'Nama minimal 3 karakter.'
                ]
            ],
            'username' => [
                'rules' => 'required|is_unique[users.npm]', // Cek unik di tabel users kolom npm
                'errors' => [
                    'required' => 'NPM wajib diisi.',
                    'is_unique' => 'NPM ini sudah terdaftar.'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'is_unique' => 'Email ini sudah terdaftar.'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Password wajib diisi.',
                    'min_length' => 'Password minimal 6 karakter.'
                ]
            ],
            'conf_password' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi password wajib diisi.',
                    'matches' => 'Konfirmasi password tidak cocok.'
                ]
            ]
        ];

        // Jalankan Validasi
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Silakan periksa kembali inputan Anda.',
                'errors' => $validation->getErrors()
            ]);
        }

        // Siapkan Data untuk Disimpan
        $data = [
            'nama'      => $this->request->getPost('fullname'),
            'npm'       => $this->request->getPost('username'),
            'email'     => $this->request->getPost('email'),
            'password'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'      => 'mahasiswa',     // Default role otomatis
            'img'       => 'default.jpg',   // Default foto profil
            'created_at'=> date('Y-m-d H:i:s')
        ];

        // Simpan ke Database
        try {
            $this->userModel->insert($data);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Registrasi berhasil! Silakan login.',
                'redirect' => base_url('login')
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ]);
        }
    }

    // =========================================================================
    // 5. LOGOUT
    // =========================================================================
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('login');
    }

    // =========================================================================
    // 6. LUPA PASSWORD
    // =========================================================================
    public function forgotPassword()
    {
        $rules = ['email' => 'required|valid_email'];
        if (!$this->validate($rules)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Format email tidak valid.']);
        }

        $email = $this->request->getPost('email');
        $user = $this->userModel->where('email', $email)->first();

        // Selalu return true agar tidak bisa ditebak emailnya (security practice)
        if (!$user) {
            return $this->response->setJSON(['success' => true, 'message' => 'Jika email terdaftar, link reset telah dikirim.']);
        }

        // Di sini nanti logika kirim email
        
        return $this->response->setJSON(['success' => true, 'message' => 'Link reset telah dikirim ke ' . $email]);
    }
}