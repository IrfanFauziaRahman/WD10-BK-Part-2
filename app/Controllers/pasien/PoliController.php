<?php

namespace App\Controllers\Pasien;
use App\Controllers\BaseController;
use App\Models\DaftarPoliModel;
use App\Models\PasienModel;
use App\Models\PoliModel;
use App\Models\JadwalPeriksaModel;

class PoliController extends BaseController
{
    protected $daftarPoliModel;
    protected $pasienModel;
    protected $poliModel;
    protected $jadwalModel;
    
    public function __construct()
    {
        $this->daftarPoliModel = new DaftarPoliModel();
        $this->pasienModel = new PasienModel();
        $this->poliModel = new PoliModel();
        $this->jadwalModel = new JadwalPeriksaModel();
    }

    public function index()
    {
        $session = session();
        
        // Cek apakah user sudah login
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Cek apakah user adalah pasien
        if ($session->get('role') !== 'pasien') {
            return redirect()->to('/login')->with('error', 'Akses ditolak');
        }

        $userId = $session->get('id');
        
        // Get patient data based on logged in user
        $pasien = $this->pasienModel->where('user_id', $userId)->first();
        
        // Jika data pasien tidak ditemukan
        if (!$pasien) {
            return redirect()->to('/login')->with('error', 'Data pasien tidak ditemukan');
        }

        // Get all poli dengan jumlah dokter
        $polis = $this->poliModel->getPoliWithDokterCount();
        
        // Get riwayat daftar poli for this patient
        $riwayat = $this->daftarPoliModel->getRiwayatByPasien($pasien['pasien_id']);

        $data = [
            'title' => 'Daftar Poli',
            'content' => 'pasien/dashboard/daftarPoli',
            'no_rm' => $pasien['no_rm'],
            'polis' => $polis,
            'riwayat' => $riwayat
        ];
        
        return view('pasien/layout', $data);
    }

    public function getJadwal()
{
    if (!$this->request->isAJAX()) {
        return $this->response->setJSON(['error' => 'Invalid Request']);
    }

    $poliId = $this->request->getPost('poli_id');
    
    // Tambahkan debug log
    log_message('debug', 'Request received for Poli ID: ' . $poliId);
    
    try {
        $jadwals = $this->jadwalModel->select('jadwal_periksa.*, dokter.nama_dokter')
            ->join('dokter', 'dokter.dokter_id = jadwal_periksa.id_dokter')
            ->where([
                'dokter.id_poli' => $poliId,
                'jadwal_periksa.status' => 'Aktif'
            ])
            ->findAll();

        // Debug log untuk hasil query
        log_message('debug', 'Jadwal found: ' . json_encode($jadwals));
        
        return $this->response->setJSON($jadwals);
    } catch (\Exception $e) {
        log_message('error', 'Error in getJadwal: ' . $e->getMessage());
        return $this->response->setJSON(['error' => $e->getMessage()]);
    }
}

    public function daftar()
    {
        $session = session();
        
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $userId = $session->get('id');
        
        // Get patient data
        $pasien = $this->pasienModel->where('user_id', $userId)->first();
        
        if (!$pasien) {
            return redirect()->back()->with('error', 'Data pasien tidak ditemukan');
        }

        $jadwalId = $this->request->getPost('jadwal');
        
        // Get next queue number
        $noAntrian = $this->daftarPoliModel->getNextAntrian($jadwalId);
            
        $data = [
            'id_pasien' => $pasien['pasien_id'],
            'id_jadwal' => $jadwalId,
            'keluhan' => $this->request->getPost('keluhan'),
            'no_antrian' => $noAntrian,
            'status' => 'menunggu'
        ];
        
        try {
            if ($this->daftarPoliModel->insert($data)) {
                return redirect()->to('/pasien/poli')->with('success', 'Berhasil mendaftar poli');
            } else {
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Gagal mendaftar poli: ' . implode(', ', $this->daftarPoliModel->errors()));
            }
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan saat mendaftar poli');
        }
    }
}