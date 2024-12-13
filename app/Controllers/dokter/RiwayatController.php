<?php

namespace App\Controllers\Dokter;
use App\Controllers\BaseController;


class RiwayatController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Riwayat Pasien',
            'content' => 'dokter/dashboard/riwayatPasien', // ini menunjuk ke view poli.php
        ];
        
        return view('dokter/layout', $data); // Memanggil layout.php
    }
}