<?php

namespace App\Controllers\Pasien;
use App\Controllers\BaseController;
use App\Models\DaftarPoliModel;
use App\Models\PasienModel;
use App\Models\DokterModel;

class Dashboard extends BaseController
{
    protected $daftarPoliModel;
    protected $pasienModel;
    protected $dokterModel;

    public function __construct()
    {
        $this->daftarPoliModel = new DaftarPoliModel();
        $this->pasienModel = new PasienModel();
        $this->dokterModel = new DokterModel();
    }

    public function index()
    {
        $userId = session()->get('id');
        $pasien = $this->pasienModel->where('user_id', $userId)->first();
        
        if (!$pasien) {
            return redirect()->to('/login');
        }

        $riwayatPoli = $this->daftarPoliModel->getRiwayatByPasien($pasien['pasien_id']);
        
        // Get active queue
        $antrianAktif = array_filter($riwayatPoli, function($poli) {
            return $poli['status'] === 'menunggu';
        });
        $antrianAktif = !empty($antrianAktif) ? reset($antrianAktif) : null;

        // Get last visit
        $kunjunganTerakhir = !empty($riwayatPoli) ? reset($riwayatPoli) : null;

        // Get doctor count per poli
        $dokterPerPoli = $this->dokterModel->select('poli.poli_id, poli.nama_poli, COUNT(dokter.dokter_id) as jumlah_dokter')
            ->join('poli', 'poli.poli_id = dokter.id_poli')
            ->groupBy('poli.poli_id')
            ->find();

        $data = [
            'title' => 'Dashboard Pasien',
            'content' => 'pasien/dashboard/pasienDashboard',
            'pasien' => $pasien,
            'riwayat_poli' => $riwayatPoli,
            'antrian_aktif' => $antrianAktif ? $antrianAktif['no_antrian'] : '-',
            'total_kunjungan' => count($riwayatPoli),
            'kunjungan_terakhir' => $kunjunganTerakhir ? date('d/m/Y', strtotime($kunjunganTerakhir['created_at'])) : '-',
            'dokter_per_poli' => $dokterPerPoli
        ];
        
        return view('pasien/layout', $data);
    }
}