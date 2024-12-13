<?php

namespace App\Controllers\Dokter;
use App\Controllers\BaseController;


class MemeriksaController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Memeriksa Pasien',
            'content' => 'dokter/dashboard/memeriksa', // ini menunjuk ke view poli.php
        ];
        
        return view('dokter/layout', $data); // Memanggil layout.php
    }
}