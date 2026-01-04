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
        // Jika sudah login, redirect ke dashboard sesuai role
        if ($this->session->get('isLoggedIn')) {
            $role = $this->session->get('role');
            if ($role === 'admin' || $role === 'superadmin') {
                return redirect()->to('dashboardadmin');
            }
            if ($role === 'rektor') {
                return redirect()->to('rektor/dashboard');
            }
            // Pastikan role === 'user' sebelum ke dashboard user
            if ($role === 'user') {
                return redirect()->to('dashboard');
            }

            // Jika role tidak dikenali, logout paksa untuk mencegah redirect loop
            $this->session->destroy();
            return redirect()->to('login');
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

        // Cari user berdasarkan NPM atau Email (dengan grouping yang benar)
        $user = $this->userModel
            ->groupStart()
            ->where('npm', $identifier)
            ->orWhere('email', $identifier)
            ->groupEnd()
            ->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return $this->response->setJSON(['success' => false, 'message' => 'NPM/Email atau Password salah.']);
        }

        // Simpan session
        $sessionData = [
            'user_id' => $user['id'],
            'npm' => $user['npm'],
            'nama' => $user['nama'],
            'email' => $user['email'],
            'img' => $user['img'],
            'role' => $user['role'],         // Tambahkan role ke session
            'isLoggedIn' => true
        ];
        $this->session->set($sessionData);

        // Redirect URL sesuai role
        if ($user['role'] === 'admin' || $user['role'] === 'superadmin') {
            $redirectUrl = base_url('/dashboardadmin');
        } elseif ($user['role'] === 'rektor') {
            $redirectUrl = base_url('/rektor/dashboard');
        } elseif ($user['role'] === 'user') {
            $redirectUrl = base_url('/dashboard');
        } else {
            // Role tidak dikenali, jangan login
            $this->session->destroy();
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Login gagal: Role akun tidak valid (' . $user['role'] . '). Hubungi admin.'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Login berhasil!',
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
                    'required' => 'NPM / Username wajib diisi.',
                    'is_unique' => 'NPM / Username ini sudah terdaftar.'
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
            'nama' => $this->request->getPost('fullname'),
            'npm' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => 'user',     // Default role otomatis
            'img' => 'default.webp',   // Default foto profil
            'created_at' => date('Y-m-d H:i:s')
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
    // =========================================================================
    // 7. PROSES KIRIM EMAIL RESET PASSWORD
    // =========================================================================
    public function forgotPasswordProcess()
    {
        // 1. Validasi Input
        $rules = [
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => ['required' => 'Email harus diisi.', 'valid_email' => 'Email tidak valid.']
            ]
        ];

        if (!$this->validate($rules)) {
            $validation = \Config\Services::validation();
            return $this->response->setJSON(['success' => false, 'message' => $validation->getError('email')]);
        }

        $email = $this->request->getPost('email');

        // 2. Cek User
        $user = $this->userModel->where('email', $email)->first();

        if (!$user) {
            // Security: Jangan beritahu user bahwa email tidak terdaftar
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Jika email terdaftar, link reset password telah dikirim ke email Anda.'
            ]);
        }

        // 3. Buat Token Random
        $token = bin2hex(random_bytes(32));

        // 4. Update Database dengan token dan expired time (1 jam)
        $this->userModel->update($user['id'], [
            'reset_token' => $token,
            'token_created_at' => date('Y-m-d H:i:s')
        ]);

        // 5. Buat Reset Link
        $resetLink = base_url('auth/reset_page?token=' . $token);

        // 6. Kirim Email
        $emailService = \Config\Services::email();

        // Render email template
        $emailBody = view('emails/reset_password_email', [
            'nama' => $user['nama'],
            'resetLink' => $resetLink
        ]);

        $emailService->setTo($email);
        $emailService->setSubject('🔐 Reset Password - E-Fasilitas Polinela');
        $emailService->setMessage($emailBody);

        if ($emailService->send()) {
            return $this->response->setJSON([
                'success' => true,
                'message' => '✅ Link reset password telah dikirim ke email <strong>' . esc($email) . '</strong>. Silakan cek inbox atau folder spam Anda.'
            ]);
        } else {
            // Log error untuk debugging
            log_message('error', 'Email sending failed: ' . $emailService->printDebugger(['headers']));

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal mengirim email. Silakan coba lagi atau hubungi administrator.'
            ]);
        }
    }

    // =========================================================================
    // 8. HALAMAN INPUT PASSWORD BARU
    // =========================================================================
    public function resetPage()
    {
        $token = $this->request->getGet('token');

        if (empty($token)) {
            return view('auth/token_expired', ['message' => 'Token tidak ditemukan.']);
        }

        // Cek apakah token ada di database
        $user = $this->userModel->where('reset_token', $token)->first();

        if (!$user) {
            return view('auth/token_expired', ['message' => 'Token tidak valid atau sudah digunakan.']);
        }

        // Cek apakah token sudah expired (1 jam = 3600 detik)
        $tokenCreatedAt = strtotime($user['token_created_at']);
        $now = time();
        $expiryTime = 3600; // 1 jam dalam detik

        if (($now - $tokenCreatedAt) > $expiryTime) {
            // Hapus token yang sudah expired
            $this->userModel->update($user['id'], [
                'reset_token' => null,
                'token_created_at' => null
            ]);
            return view('auth/token_expired', ['message' => 'Link reset password telah kedaluwarsa. Silakan request ulang.']);
        }

        return view('auth/reset_password', ['token' => $token]);
    }

    // =========================================================================
    // 9. PROSES SIMPAN PASSWORD BARU
    // =========================================================================
    public function changePasswordProcess()
    {
        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');

        $user = $this->userModel->where('reset_token', $token)->first();

        if ($user) {
            $this->userModel->update($user['id'], [
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'reset_token' => null, // Hapus token
                'token_created_at' => null
            ]);

            // Redirect ke login dengan pesan
            session()->setFlashdata('message', 'Password berhasil diubah! Silakan login.');
            return redirect()->to('/'); // Kembali ke Login
        } else {
            return "Gagal mengubah password.";
        }
    }
}
