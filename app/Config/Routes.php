<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Rute Publik
$routes->get('/', 'Home::index');

// Rute Autentikasi (Untuk Login, Logout, dll.)
$routes->get('/login', 'AuthController::index');
$routes->post('/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');
$routes->post('/forgot-password', 'AuthController::forgotPassword');

// --- TAMBAHAN BARU UNTUK REGISTER ---
$routes->get('/register', 'AuthController::register');          // 1. Menampilkan Halaman Daftar
$routes->post('/register/process', 'AuthController::processRegister'); // 2. Memproses Data (AJAX)

// Rute yang Dilindungi (Membutuhkan Login)
// Filter 'auth' akan berjalan sebelum mengakses controller ini.
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);
$routes->get('/laporan', 'LaporController::index', ['filter' => 'auth']);
$routes->post('laporan/store', 'LaporController::store', ['filter' => 'auth']);




$routes->get('/laporan/saya', 'LaporController::saya', ['filter' => 'auth']);
$routes->get('laporan/edit/(:num)', 'LaporController::edit/$1', ['filter' => 'auth']);
$routes->post('laporan/update/(:num)', 'LaporController::update/$1', ['filter' => 'auth']);
$routes->post('/laporan/update/(:num)', 'LaporController::update/$1', ['filter' => 'auth']);
$routes->get('/laporan/delete/(:num)', 'LaporController::delete/$1', ['filter' => 'auth']);



// $routes->get('/laporan/detail/(:num)', 'LaporController::detail/$1', ['filter' => 'auth']);
$routes->get('laporan/detail/(:num)', 'LaporController::detail/$1', ['filter' => 'auth']);


$routes->get('/laporan/riwayat', 'LaporController::riwayat', ['filter' => 'auth']);

$routes->get('/profile', 'ProfileController::index', ['filter' => 'auth']);
$routes->post('/profile/update', 'ProfileController::update', ['filter' => 'auth']);



// --- TAMBAHKAN RUTE PROFIL DI SINI ---
$routes->get('/profileadmin', 'ProfileAdminController::index', ['filter' => 'auth']);
$routes->post('/profileadmin/update', 'ProfileAdminController::update', ['filter' => 'auth']);
// ------------------------------------


$routes->get('/laporanadminpending', 'AdminLaporController::index', ['filter' => 'admin']);
$routes->get('/laporanadmindiproses', 'AdminLaporController::index', ['filter' => 'admin']);
$routes->get('/riwayatadmin', 'AdminLaporController::index', ['filter' => 'admin']);

$routes->post('/admin/laporan/verifikasi', 'AdminLaporController::verifikasi', ['filter' => 'admin']);

// Manajemen Akun (dropdown)
$routes->get('akunadmin', 'AdminAkunController::index', ['filter' => 'admin']);
$routes->get('akunuser', 'AdminAkunController::index', ['filter' => 'admin']);

// Edit & delete
$routes->post('/akun/store', 'AdminAkunController::store', ['filter' => 'admin']);
$routes->post('akun/update', 'AdminAkunController::update', ['filter' => 'admin']);
$routes->get('akun/delete/(:num)', 'AdminAkunController::delete/$1', ['filter' => 'admin']);

// Halaman detail (opsional)
$routes->get('admin/laporan/detail/(:num)', 'AdminLaporController::detail/$1', ['filter' => 'admin']);

$routes->get('/dashboardadmin', 'AdminDashboard::index', ['filter' => 'admin']);
$routes->get('/laporanadmin', 'AdminLaporController::index', ['filter' => 'admin']);
$routes->post('/laporanadmin', 'AdminLaporController::index', ['filter' => 'admin']);
$routes->get('/riwayatadmin', 'AdminLaporController::riwayat', ['filter' => 'admin']);
$routes->post('admin/laporan/verifikasi', 'AdminLaporController::verifikasi', ['filter' => 'admin']);
$routes->get('/admindetail/(:num)', 'AdminLaporController::detail/$1', ['filter' => 'admin']);

$routes->get('/profileadmin', 'ProfileAdminController::index', ['filter' => 'admin']);
$routes->post('admin/profile/update', 'ProfileAdminController::update', ['filter' => 'admin']);

$routes->group('', ['namespace' => 'App\Controllers', 'filter' => 'admin'], function ($routes) {

    // ===========================
    // AKUN
    // ===========================
    $routes->get('akun/admin', 'AkunController::indexAdmin');
    $routes->get('akun/user', 'AkunController::indexUser');
    $routes->post('akun/create', 'AkunController::store');
    $routes->post('akun/update', 'AkunController::update');
    $routes->get('akun/delete/(:num)', 'AkunController::delete/$1');

    // ===========================
    // GEDUNG
    // ===========================
    $routes->get('gedung', 'AdminGedungController::index');
    $routes->post('gedung/create', 'AdminGedungController::store');
    $routes->post('gedung/update', 'AdminGedungController::update');
    $routes->get('gedung/delete/(:num)', 'AdminGedungController::delete/$1');
});

// =========================================================================
// RUTE NOTIFIKASI
// =========================================================================
$routes->get('/notifikasi', 'NotifikasiController::index', ['filter' => 'auth']);
$routes->get('/notifikasi/view/(:num)', 'NotifikasiController::view/$1', ['filter' => 'auth']);
$routes->get('/notifikasi/mark-read/(:num)', 'NotifikasiController::markAsRead/$1', ['filter' => 'auth']);
$routes->get('/notifikasi/mark-all-read', 'NotifikasiController::markAllAsRead', ['filter' => 'auth']);
$routes->get('/notifikasi/delete/(:num)', 'NotifikasiController::delete/$1', ['filter' => 'auth']);
$routes->get('/notifikasi/delete-all', 'NotifikasiController::deleteAll', ['filter' => 'auth']);
$routes->get('/notifikasi/unread-count', 'NotifikasiController::getUnreadCount', ['filter' => 'auth']);

// =========================================================================
// RUTE NOTIFIKASI ADMIN
// =========================================================================
$routes->get('/admin/notifikasi', 'AdminNotifikasiController::index', ['filter' => 'admin']);
$routes->get('/admin/notifikasi/view/(:num)', 'AdminNotifikasiController::view/$1', ['filter' => 'admin']);
$routes->get('/admin/notifikasi/unread-count', 'AdminNotifikasiController::getUnreadCount', ['filter' => 'admin']);
$routes->get('/admin/notifikasi/mark-all-read', 'AdminNotifikasiController::markAllAsRead', ['filter' => 'admin']);
$routes->get('/admin/notifikasi/delete/(:num)', 'AdminNotifikasiController::delete/$1', ['filter' => 'admin']);

// =========================================================================
// RUTE REKTOR
// =========================================================================
$routes->group('rektor', ['filter' => 'rektor'], function ($routes) {
    $routes->get('dashboard', 'RektorController::index');
    $routes->get('laporan', 'RektorController::laporan');
    $routes->get('statistik', 'RektorController::statistik');
    $routes->get('audit-log', 'RektorController::auditLog');
});
