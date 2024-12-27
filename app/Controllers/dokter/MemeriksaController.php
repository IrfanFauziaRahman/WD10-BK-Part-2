<?php
namespace App\Controllers\Dokter;
use App\Controllers\BaseController;
use App\Models\MemeriksaModel;
use App\Models\PeriksaModel;
use App\Models\ObatModel;
use App\Models\DokterModel;

class MemeriksaController extends BaseController {
    protected $memeriksaModel;
    protected $periksaModel;
    protected $obatModel;
    protected $dokterModel;

    public function __construct() {
        $this->memeriksaModel = new MemeriksaModel();
        $this->periksaModel = new PeriksaModel();
        $this->obatModel = new ObatModel();
        $this->dokterModel = new DokterModel();
    }

    public function index() {
        // Ambil user_id dari session
        $userId = session()->get('id');

        // Ambil data dokter berdasarkan user_id
        $dokter = $this->dokterModel->where('user_id', $userId)->first();
        
        if (!$dokter) {
            return redirect()->back()->with('error', 'Data dokter tidak ditemukan');
        }

        // Ambil daftar poli khusus untuk dokter yang login
        $daftarPoli = $this->memeriksaModel->getDaftarPoliByDokter($dokter['dokter_id']);

        return view('dokter/layout', [
            'title' => 'Memeriksa Pasien',
            'content' => 'dokter/dashboard/memeriksa',
            'daftarPoli' => $daftarPoli
        ]);
    }

    public function mulaiPeriksa($id) {
        $userId = session()->get('id');
        $dokter = $this->dokterModel->where('user_id', $userId)->first();

        // Validasi akses
        $daftarPoli = $this->memeriksaModel->getDaftarPoliDetail($id);
        if (!$daftarPoli || $daftarPoli['id_dokter'] != $dokter['dokter_id']) {
            return redirect()->to('/dokter/memeriksa')->with('error', 'Akses tidak valid');
        }

        $this->memeriksaModel->update($id, ['status' => 'diperiksa']);

        return view('dokter/layout', [
            'title' => 'Form Pemeriksaan',
            'content' => 'dokter/dashboard/form_periksa',
            'daftarPoli' => $daftarPoli,
            'obatList' => $this->obatModel->findAll()
        ]);
    }

    public function lanjutkan($id) {
        $userId = session()->get('id');
        $dokter = $this->dokterModel->where('user_id', $userId)->first();

        // Validasi akses
        $daftarPoli = $this->memeriksaModel->getDaftarPoliDetail($id);
        if (!$daftarPoli || $daftarPoli['id_dokter'] != $dokter['dokter_id']) {
            return redirect()->to('/dokter/memeriksa')->with('error', 'Akses tidak valid');
        }

        if ($daftarPoli['status'] !== 'diperiksa') {
            return redirect()->to('/dokter/memeriksa')->with('error', 'Status pemeriksaan tidak valid');
        }

        return view('dokter/layout', [
            'title' => 'Lanjutkan Pemeriksaan',
            'content' => 'dokter/dashboard/form_periksa',
            'daftarPoli' => $daftarPoli,
            'obatList' => $this->obatModel->findAll()
        ]);
    }

    public function simpanPemeriksaan() {
        $userId = session()->get('id');
        $dokter = $this->dokterModel->where('user_id', $userId)->first();
        $idDaftarPoli = $this->request->getPost('id_daftar_poli');
    
        // Validasi akses
        $daftarPoli = $this->memeriksaModel->getDaftarPoliDetail($idDaftarPoli);
        if (!$daftarPoli || $daftarPoli['id_dokter'] != $dokter['dokter_id']) {
            return redirect()->to('/dokter/memeriksa')->with('error', 'Akses tidak valid');
        }
    
        $db = \Config\Database::connect();
        $biayaJasa = 150000;
        $totalObat = $this->request->getPost('total_obat');
        
        // Check if this is an edit
        $existingPeriksa = $this->periksaModel->where('id_daftar_poli', $idDaftarPoli)->first();
        
        if ($existingPeriksa) {
            // Update existing record
            $dataPemeriksaan = [
                'catatan' => $this->request->getPost('catatan'),
                'biaya_periksa' => $biayaJasa + $totalObat
            ];
            
            $this->periksaModel->update($existingPeriksa['id'], $dataPemeriksaan);
            
            // Delete existing detail_periksa
            $db->table('detail_periksa')->where('id_periksa', $existingPeriksa['id'])->delete();
            
            // Insert new detail_periksa
            $obatIds = $this->request->getPost('obat');
            if (!empty($obatIds)) {
                foreach ($obatIds as $idObat) {
                    if (!empty($idObat)) {
                        $dataDetailPeriksa = [
                            'id_periksa' => $existingPeriksa['id'],
                            'id_obat' => $idObat
                        ];
                        $db->table('detail_periksa')->insert($dataDetailPeriksa);
                    }
                }
            }
    
            return redirect()->to('/dokter/memeriksa')->with('success', 'Data pemeriksaan berhasil diupdate');
        } else {
            // Insert new record
            $dataPemeriksaan = [
                'id_daftar_poli' => $idDaftarPoli,
                'tgl_periksa' => date('Y-m-d'),
                'catatan' => $this->request->getPost('catatan'),
                'biaya_periksa' => $biayaJasa + $totalObat
            ];
            
            $this->periksaModel->insert($dataPemeriksaan);
            $idPeriksa = $this->periksaModel->insertID();
            
            // Insert detail_periksa
            $obatIds = $this->request->getPost('obat');
            if (!empty($obatIds)) {
                foreach ($obatIds as $idObat) {
                    if (!empty($idObat)) {
                        $dataDetailPeriksa = [
                            'id_periksa' => $idPeriksa,
                            'id_obat' => $idObat
                        ];
                        $db->table('detail_periksa')->insert($dataDetailPeriksa);
                    }
                }
            }
            
            // Update status menjadi selesai
            $this->memeriksaModel->update($idDaftarPoli, ['status' => 'selesai']);
            
            return redirect()->to('/dokter/memeriksa')->with('success', 'Pemeriksaan berhasil disimpan');
        }
    }

    public function detail($id) {
        $userId = session()->get('id');
        $dokter = $this->dokterModel->where('user_id', $userId)->first();

        // Validasi akses
        $daftarPoli = $this->memeriksaModel->getDaftarPoliDetail($id);
        if (!$daftarPoli || $daftarPoli['id_dokter'] != $dokter['dokter_id']) {
            return redirect()->to('/dokter/memeriksa')->with('error', 'Akses tidak valid');
        }

        $periksa = $this->periksaModel->where('id_daftar_poli', $id)->first();

        return view('dokter/layout', [
            'title' => 'Detail Pemeriksaan',
            'content' => 'dokter/dashboard/detail_periksa',
            'periksa' => $periksa,
            'daftarPoli' => $daftarPoli
        ]);
    }

    public function edit($id) {
        $userId = session()->get('id');
        $dokter = $this->dokterModel->where('user_id', $userId)->first();
    
        // Validasi akses
        $daftarPoli = $this->memeriksaModel->getDaftarPoliDetail($id);
        if (!$daftarPoli || $daftarPoli['id_dokter'] != $dokter['dokter_id']) {
            return redirect()->to('/dokter/memeriksa')->with('error', 'Akses tidak valid');
        }
    
        // Get periksa data
        $periksa = $this->periksaModel->where('id_daftar_poli', $id)->first();
        
        // Get detail obat
        $detailObat = $db = \Config\Database::connect()
            ->table('detail_periksa')
            ->select('detail_periksa.*, obat.*')
            ->join('obat', 'obat.obat_id = detail_periksa.id_obat')
            ->where('detail_periksa.id_periksa', $periksa['id'])
            ->get()
            ->getResultArray();
    
        return view('dokter/layout', [
            'title' => 'Edit Pemeriksaan',
            'content' => 'dokter/dashboard/form_periksa',
            'daftarPoli' => $daftarPoli,
            'obatList' => $this->obatModel->findAll(),
            'periksa' => $periksa,
            'detailObat' => $detailObat
        ]);
    }
}