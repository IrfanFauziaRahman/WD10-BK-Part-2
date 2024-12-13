<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/adminDashboard', 'Admin\Dashboard::index');
$routes->get('/poli', 'Admin\PoliController::index');
$routes->get('/adminDokter', 'Admin\DokterController::index');
$routes->get('/adminPasien', 'Admin\PasienController::index');
$routes->get('/obat', 'Admin\ObatController::index');
$routes->get('/pasienDashboard', 'Pasien\Dashboard::index');
$routes->get('/daftarPoli', 'Pasien\DafPoli::index');
$routes->get('/dokDashboard', 'Dokter\Dashboard::index');
$routes->get('/jadwal', 'Dokter\JadwalController::index');
$routes->get('/memeriksa', 'Dokter\MemeriksaController::index');
$routes->get('/riwayatPasien', 'Dokter\RiwayatController::index');

$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
    $routes->get('poli', 'PoliController::index');
    $routes->post('poli/save', 'PoliController::save');
    $routes->get('poli/edit/(:num)', 'PoliController::edit/$1'); // Routing untuk edit
    $routes->post('poli/update/(:num)', 'PoliController::update/$1'); // Routing untuk update
    $routes->get('poli/delete/(:num)', 'PoliController::delete/$1');
});

$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
    $routes->get('dokter', 'DokterController::index');
    $routes->post('dokter/save', 'DokterController::save');
    $routes->get('dokter/edit/(:num)', 'DokterController::edit/$1'); // Routing untuk edit
    $routes->post('dokter/update/(:num)', 'DokterController::update/$1'); // Routing untuk update
    $routes->get('dokter/delete/(:num)', 'DokterController::delete/$1'); // Routing untuk hapus
});

$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
    // Rute untuk pasien
    $routes->get('pasien', 'PasienController::index');                   // Halaman utama pasien
    $routes->post('pasien/save', 'PasienController::save');              // Proses simpan pasien baru
    $routes->get('pasien/edit/(:num)', 'PasienController::edit/$1');     // Halaman edit pasien berdasarkan ID
    $routes->post('pasien/update/(:num)', 'PasienController::update/$1'); // Proses update pasien berdasarkan ID
    $routes->get('pasien/delete/(:num)', 'PasienController::delete/$1'); // Hapus pasien berdasarkan ID
});

$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
    // Rute untuk obat
    $routes->get('obat', 'ObatController::index');                     // Halaman utama obat
    $routes->post('obat/save', 'ObatController::save');                // Proses simpan obat baru
    $routes->get('obat/edit/(:num)', 'ObatController::edit/$1');       // Halaman edit obat berdasarkan ID
    $routes->post('obat/update/(:num)', 'ObatController::update/$1');  // Proses update obat berdasarkan ID
    $routes->get('obat/delete/(:num)', 'ObatController::delete/$1');   // Hapus obat berdasarkan ID
});


$routes->get('/login', 'AuthController::login');
$routes->get('/register', 'AuthController::register');
$routes->post('/login/auth', 'AuthController::auth');
$routes->get('/logout', 'AuthController::logout');

$routes->post('/auth/registerAction', 'AuthController::registerAction');
