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

// Rute yang Dilindungi (Membutuhkan Login)
// Filter 'auth' akan berjalan sebelum mengakses controller ini.
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);
$routes->get('/lapor', 'LaporController::index', ['filter' => 'auth']);
$routes->post('/lapor/store', 'LaporController::store', ['filter' => 'auth']);
$routes->get('/laporan/status', 'LaporController::status', ['filter' => 'auth']); //
$routes->get('/laporan/riwayat', 'LaporController::riwayat', ['filter' => 'auth']); // <-- TAMBAHKAN INI
$routes->get('/laporan/detail/(:num)', 'LaporController::detail/$1', ['filter' => 'auth']); // <-- TAMBAHKAN INI

// --- TAMBAHKAN RUTE PROFIL DI SINI ---
$routes->get('/profile', 'ProfileController::index', ['filter' => 'auth']);
$routes->post('/profile/update', 'ProfileController::update', ['filter' => 'auth']);
// ------------------------------------

$routes->get('/dashboardadmin', 'AdminDashboard::index', ['filter' => 'auth']);
$routes->get('/laporanadmin', 'AdminLaporController::index', ['filter' => 'auth']);
$routes->post('/laporanadmin', 'AdminLaporController::index', ['filter' => 'auth']);
$routes->get('/riwayatadmin', 'AdminLaporController::riwayat', ['filter' => 'auth']);
$routes->post('admin/laporan/verifikasi', 'AdminLaporController::verifikasi');
$routes->get('/admindetail/(:num)', 'AdminLaporController::detail/$1', ['filter' => 'auth']);
