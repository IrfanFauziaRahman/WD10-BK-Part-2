<?php

namespace App\Controllers\Dokter;
use App\Controllers\BaseController;


class Dashboard extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dokter Dashboard',
            'content' => 'dokter/dashboard/dokDashboard', // ini menunjuk ke view poli.php
        ];
        
        return view('dokter/layout', $data); // Memanggil layout.php
    }
}
