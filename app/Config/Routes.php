<?php

use CodeIgniter\Router\RouteCollection;

/**
* @var RouteCollection $routes
*/

// Basic routes
$routes->get('/', 'Home::index');
$routes->get('/login', 'AuthController::login');
$routes->get('/register', 'AuthController::register');
$routes->post('/login/auth', 'AuthController::auth');
$routes->get('/logout', 'AuthController::logout');
$routes->post('/auth/registerAction', 'AuthController::registerAction');

// Dashboard routes
$routes->get('/adminDashboard', 'Admin\Dashboard::index');
$routes->get('/pasienDashboard', 'Pasien\Dashboard::index');
$routes->get('/dokDashboard', 'Dokter\Dashboard::index');

// Admin routes group
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
    // Poli routes
    $routes->get('poli', 'PoliController::index');
    $routes->post('poli/save', 'PoliController::save');
    $routes->get('poli/edit/(:num)', 'PoliController::edit/$1');
    $routes->post('poli/update/(:num)', 'PoliController::update/$1');
    $routes->get('poli/delete/(:num)', 'PoliController::delete/$1');
    
    // Dokter routes
    $routes->get('dokter', 'DokterController::index');
    $routes->post('dokter/save', 'DokterController::save');
    $routes->get('dokter/edit/(:num)', 'DokterController::edit/$1');
    $routes->post('dokter/update/(:num)', 'DokterController::update/$1');
    $routes->get('dokter/delete/(:num)', 'DokterController::delete/$1');
    
    // Pasien routes
    $routes->get('pasien', 'PasienController::index');
    $routes->post('pasien/save', 'PasienController::save');
    $routes->get('pasien/edit/(:num)', 'PasienController::edit/$1');
    $routes->post('pasien/update/(:num)', 'PasienController::update/$1');
    $routes->get('pasien/delete/(:num)', 'PasienController::delete/$1');
    
    // Obat routes
    $routes->get('obat', 'ObatController::index');
    $routes->post('obat/save', 'ObatController::save');
    $routes->get('obat/edit/(:num)', 'ObatController::edit/$1');
    $routes->post('obat/update/(:num)', 'ObatController::update/$1');
    $routes->get('obat/delete/(:num)', 'ObatController::delete/$1');
});

// Dokter routes group
$routes->group('dokter', ['namespace' => 'App\Controllers\Dokter'], function ($routes) {
    // Jadwal routes
    $routes->get('jadwal', 'JadwalController::index');
    $routes->post('jadwal/create', 'JadwalController::create');
    $routes->post('jadwal/update/(:num)', 'JadwalController::update/$1');
    
    // Memeriksa routes
    $routes->get('memeriksa', 'MemeriksaController::index');
    $routes->get('memeriksa/mulai/(:num)', 'MemeriksaController::mulaiPeriksa/$1');
    $routes->post('memeriksa/simpan', 'MemeriksaController::simpanPemeriksaan');
    $routes->get('memeriksa/detail/(:num)', 'MemeriksaController::detail/$1');
    $routes->get('memeriksa/lanjutkan/(:num)', 'MemeriksaController::lanjutkan/$1');
    $routes->get('memeriksa/edit/(:num)', 'MemeriksaController::edit/$1');
    
    // Riwayat routes
    $routes->get('riwayat', 'RiwayatController::index');
    $routes->get('riwayat/detail/(:num)', 'RiwayatController::detail/$1');
    
    // Profil routes
    $routes->get('profil', 'ProfilController::index');
    $routes->post('profil/update', 'ProfilController::update');
});

// Pasien routes group
$routes->group('pasien', ['namespace' => 'App\Controllers\Pasien'], function($routes) {
    $routes->get('poli', 'PoliController::index');
    $routes->post('poli/getJadwal', 'PoliController::getJadwal');
    $routes->post('poli/daftar', 'PoliController::daftar');
});