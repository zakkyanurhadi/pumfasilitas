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
$routes->get('/logout', 'AuthController::logout'); // <-- Baris ini sudah diperbaiki
$routes->post('/forgot-password', 'AuthController::forgotPassword');
$routes->get('register', 'AuthController::registerForm');
$routes->post('register', 'AuthController::register');

// Rute yang Dilindungi (Membutuhkan Login)
// Filter 'auth' akan berjalan sebelum mengakses controller ini.
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);
$routes->get('lapor', 'LaporController::buat');
$routes->post('lapor/store', 'LaporController::simpan');

// Status semua laporan user
$routes->get('lapor/status', 'LaporController::status');

// Riwayat laporan selesai
$routes->get('lapor/riwayat', 'LaporController::riwayat');

// Detail laporan
$routes->get('lapor/detail/(:num)', 'LaporController::detail/$1'); // <-- TAMBAHKAN INI




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

$routes->group('', ['namespace' => 'App\Controllers'], function($routes) {

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

