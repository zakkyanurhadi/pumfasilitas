<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Rute Publik
$routes->get('/', 'Home::index');

// Route Debug Email (HAPUS SETELAH SELESAI DEBUG)
$routes->get('test-email', 'TestEmail::index');
$routes->get('test-email/send', 'TestEmail::send');

// Rute Autentikasi (Untuk Login, Logout, dll.)
$routes->get('login', 'AuthController::index');
$routes->post('login', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');
$routes->post('forgot-password', 'AuthController::forgotPassword');
$routes->post('auth/forgot_process', 'AuthController::forgotPasswordProcess');
$routes->get('auth/reset_page', 'AuthController::resetPage');
$routes->post('auth/change_password', 'AuthController::changePasswordProcess');

// --- TAMBAHAN BARU UNTUK REGISTER ---
$routes->get('register', 'AuthController::register');          // 1. Menampilkan Halaman Daftar
$routes->post('register/process', 'AuthController::processRegister'); // 2. Memproses Data (AJAX)

// Rute yang Dilindungi (Membutuhkan Login)
// Filter 'auth' akan berjalan sebelum mengakses controller ini.
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);
$routes->get('laporan', 'LaporController::index', ['filter' => 'auth']);
$routes->post('laporan/store', 'LaporController::store', ['filter' => 'auth']);




$routes->get('laporan/saya', 'LaporController::saya', ['filter' => 'auth']);
$routes->get('laporan/edit/(:num)', 'LaporController::edit/$1', ['filter' => 'auth']);
$routes->post('laporan/update/(:num)', 'LaporController::update/$1', ['filter' => 'auth']);
$routes->post('laporan/update/(:num)', 'LaporController::update/$1', ['filter' => 'auth']);
$routes->get('laporan/delete/(:num)', 'LaporController::delete/$1', ['filter' => 'auth']);



// $routes->get('/laporan/detail/(:num)', 'LaporController::detail/$1', ['filter' => 'auth']);
$routes->get('laporan/detail/(:num)', 'LaporController::detail/$1', ['filter' => 'auth']);


$routes->get('laporan/riwayat', 'LaporController::riwayat', ['filter' => 'auth']);

$routes->get('profile', 'ProfileController::index', ['filter' => 'auth']);
$routes->post('profile/update', 'ProfileController::update', ['filter' => 'auth']);






// =========================================================================
// RUTE ADMIN (EX SUPERADMIN) + ADMIN1 (EX ADMIN)
// =========================================================================

// Shared Dashboard (Bisa diakses Admin & Admin1)
// Menggunakan filter 'admin1' karena admin1 = level bawah, level atas (admin) juga bisa akses jika filter mengizinkan
$routes->get('dashboardadmin', 'AdminDashboard::index', ['filter' => 'admin1']);

// Laporan (Admin & Admin1)
$routes->get('laporanadmin', 'AdminLaporController::index', ['filter' => 'admin1']);
$routes->post('laporanadmin', 'AdminLaporController::index', ['filter' => 'admin1']);

$routes->get('laporanadminpending', 'AdminLaporController::index', ['filter' => 'admin1']);
$routes->get('laporanadmindiproses', 'AdminLaporController::index', ['filter' => 'admin1']);
$routes->get('riwayatadmin', 'AdminLaporController::riwayat', ['filter' => 'admin1']);

$routes->post('admin/laporan/verifikasi', 'AdminLaporController::verifikasi', ['filter' => 'admin1']);
$routes->get('admindetail/(:num)', 'AdminLaporController::detail/$1', ['filter' => 'admin1']);
$routes->get('admin/laporan/detail/(:num)', 'AdminLaporController::detail/$1', ['filter' => 'admin1']);


// Profile Admin (Admin & Admin1)
$routes->get('profileadmin', 'ProfileAdminController::index', ['filter' => 'admin1']);
$routes->post('admin/profile/update', 'ProfileAdminController::update', ['filter' => 'admin1']);


// ===========================
// KHUSUS ADMIN (EX SUPERADMIN)
// ===========================

// Manajemen Akun Admin/User (Hanya Admin)
$routes->get('akunadmin', 'AdminAkunController::index', ['filter' => 'admin']);
$routes->get('akunuser', 'AdminAkunController::index', ['filter' => 'admin1']); // Admin1 bisa lihat user? Asumsi ya.

// CRUD Akun
$routes->group('', ['namespace' => 'App\Controllers', 'filter' => 'admin'], function ($routes) {
    // Hanya Admin yang bisa create/delete admin lain
    $routes->post('/akun/store', 'AdminAkunController::store');
    $routes->post('akun/update', 'AdminAkunController::update');
    $routes->get('akun/delete/(:num)', 'AdminAkunController::delete/$1');

    // Route lama untuk kompatibilitas jika ada
    $routes->get('akun/admin', 'AkunController::indexAdmin');
    //$routes->get('akun/user', 'AkunController::indexUser'); // Dipindah ke admin1 filter jika perlu
    $routes->post('akun/create', 'AkunController::store');
    //$routes->post('akun/update', 'AkunController::update');
    //$routes->get('akun/delete/(:num)', 'AkunController::delete/$1');
});

// CRUD Gedung (Hanya Admin)
$routes->group('', ['namespace' => 'App\Controllers', 'filter' => 'admin'], function ($routes) {
    $routes->get('gedung', 'AdminGedungController::index');
    $routes->post('gedung/create', 'AdminGedungController::store');
    $routes->post('gedung/update', 'AdminGedungController::update');
    $routes->get('gedung/delete/(:num)', 'AdminGedungController::delete/$1');
});


// =========================================================================
// RUTE NOTIFIKASI
// =========================================================================
$routes->get('notifikasi', 'NotifikasiController::index', ['filter' => 'auth']);
$routes->get('notifikasi/view/(:num)', 'NotifikasiController::view/$1', ['filter' => 'auth']);
$routes->get('notifikasi/mark-read/(:num)', 'NotifikasiController::markAsRead/$1', ['filter' => 'auth']);
$routes->get('notifikasi/mark-all-read', 'NotifikasiController::markAllAsRead', ['filter' => 'auth']);
$routes->get('notifikasi/delete/(:num)', 'NotifikasiController::delete/$1', ['filter' => 'auth']);
$routes->get('notifikasi/delete-all', 'NotifikasiController::deleteAll', ['filter' => 'auth']);
$routes->get('notifikasi/unread-count', 'NotifikasiController::getUnreadCount', ['filter' => 'auth']);

// =========================================================================
// RUTE NOTIFIKASI ADMIN (Admin & Admin1)
// =========================================================================
$routes->get('admin/notifikasi', 'AdminNotifikasiController::index', ['filter' => 'admin1']);
$routes->get('admin/notifikasi/view/(:num)', 'AdminNotifikasiController::view/$1', ['filter' => 'admin1']);
$routes->get('admin/notifikasi/unread-count', 'AdminNotifikasiController::getUnreadCount', ['filter' => 'admin1']);
$routes->get('admin/notifikasi/mark-all-read', 'AdminNotifikasiController::markAllAsRead', ['filter' => 'admin1']);
$routes->get('admin/notifikasi/mark-read/(:num)', 'AdminNotifikasiController::markRead/$1', ['filter' => 'admin1']);
$routes->get('admin/notifikasi/delete/(:num)', 'AdminNotifikasiController::delete/$1', ['filter' => 'admin1']);
$routes->get('admin/notifikasi/delete-all', 'AdminNotifikasiController::deleteAll', ['filter' => 'admin1']);

// =========================================================================
// RUTE DIREKTUR (EX REKTOR)
// =========================================================================
$routes->group('direktur', ['filter' => 'direktur'], function ($routes) {
    $routes->get('dashboard', 'DirekturController::index');
    $routes->get('laporan', 'DirekturController::laporan');
    $routes->get('statistik', 'DirekturController::statistik');
    $routes->get('audit-log', 'DirekturController::auditLog');

    // Profile
    $routes->get('profile', 'ProfileDirekturController::index');
    $routes->post('profile/update', 'ProfileDirekturController::update');
});
