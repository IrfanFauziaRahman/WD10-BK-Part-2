<?php

namespace App\Controllers\Pasien;
use App\Controllers\BaseController;


class DafPoli extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Poliklinik Daftar Poli',
            'content' => 'pasien/dashboard/daftarPoli', // ini menunjuk ke view poli.php
        ];
        
        return view('pasien/layout', $data); // Memanggil layout.php
    }
}
