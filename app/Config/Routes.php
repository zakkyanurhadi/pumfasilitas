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


$routes->get('/laporanadminpending', 'AdminLaporController::index');
$routes->get('/laporanadmindiproses', 'AdminLaporController::index');
$routes->get('/riwayatadmin', 'AdminLaporController::index');

$routes->post('/admin/laporan/verifikasi', 'AdminLaporController::verifikasi');

// Manajemen Akun (dropdown)
$routes->get('akunadmin', 'AdminAkunController::index');
$routes->get('akunuser', 'AdminAkunController::index');

// Edit & delete
$routes->post('/akun/store', 'AdminAkunController::store');
$routes->post('akun/update', 'AdminAkunController::update');
$routes->get('akun/delete/(:num)', 'AdminAkunController::delete/$1');

// Halaman detail (opsional)
$routes->get('admin/laporan/detail/(:num)', 'AdminLaporController::detail/$1');

$routes->get('/dashboardadmin', 'AdminDashboard::index', ['filter' => 'auth']);
$routes->get('/laporanadmin', 'AdminLaporController::index', ['filter' => 'auth']);
$routes->post('/laporanadmin', 'AdminLaporController::index', ['filter' => 'auth']);
$routes->get('/riwayatadmin', 'AdminLaporController::riwayat', ['filter' => 'auth']);
$routes->post('admin/laporan/verifikasi', 'AdminLaporController::verifikasi');
$routes->get('/admindetail/(:num)', 'AdminLaporController::detail/$1', ['filter' => 'auth']);

$routes->get('/profileadmin', 'ProfileAdminController::index', ['filter' => 'auth']);
$routes->post('admin/profile/update', 'ProfileAdminController::update', ['filter' => 'auth']);

$routes->group('', ['namespace' => 'App\Controllers'], function ($routes) {

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
