<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DokterModel;
use App\Models\PasienModel;
use App\Models\PoliModel;
use App\Models\ObatModel;

class Dashboard extends BaseController
{
    public function index()
    {
        // Load model
        $dokterModel = new DokterModel();
        $pasienModel = new PasienModel();
        $poliModel = new PoliModel();
        $obatModel = new ObatModel();

        // Ambil jumlah total dari masing-masing tabel
        $data = [
            'title' => 'Admin Dashboard',
            'content' => 'admin/dashboard/adminDashboard', // View
            'total_dokter' => $dokterModel->countAll(),
            'total_pasien' => $pasienModel->countAll(),
            'total_poli'   => $poliModel->countAll(),
            'total_obat'   => $obatModel->countAll(),
        ];

        // Return ke layout utama
        return view('admin/layout', $data);
    }
}
