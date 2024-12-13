<?php

namespace App\Controllers\Dokter;
use App\Controllers\BaseController;


class JadwalController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Jadwal Periksa',
            'content' => 'dokter/dashboard/jadwal', // ini menunjuk ke view poli.php
        ];
        
        return view('dokter/layout', $data); // Memanggil layout.php
    }
}