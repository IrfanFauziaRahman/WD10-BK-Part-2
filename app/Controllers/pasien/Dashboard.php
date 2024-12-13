<?php

namespace App\Controllers\Pasien;
use App\Controllers\BaseController;


class Dashboard extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Pasien Dashboard',
            'content' => 'pasien/dashboard/pasienDashboard', // ini menunjuk ke view poli.php
        ];
        
        return view('pasien/layout', $data); // Memanggil layout.php
    }
}
