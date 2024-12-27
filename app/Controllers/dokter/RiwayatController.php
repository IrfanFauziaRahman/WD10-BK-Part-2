<?php
namespace App\Controllers\Dokter;
use App\Controllers\BaseController;
use App\Models\RiwayatModel;
use App\Models\DokterModel;

class RiwayatController extends BaseController
{
   protected $riwayatModel;
   protected $dokterModel;

   public function __construct()
   {
       $this->riwayatModel = new RiwayatModel();
       $this->dokterModel = new DokterModel();
   }

   public function index()
   {
       $userId = session()->get('id');
       $dokter = $this->dokterModel->where('user_id', $userId)->first();
       
       if (!$dokter) {
           return redirect()->back()->with('error', 'Data dokter tidak ditemukan');
       }

       $db = \Config\Database::connect();
       
       $riwayatPeriksa = $db->table('periksa')
           ->select('periksa.*, daftar_poli.keluhan, daftar_poli.created_at, 
                    pasien.*, dokter.nama_dokter, 
                    GROUP_CONCAT(obat.nama_obat SEPARATOR ", ") as obat_list')
           ->join('daftar_poli', 'daftar_poli.id = periksa.id_daftar_poli')
           ->join('pasien', 'pasien.pasien_id = daftar_poli.id_pasien')
           ->join('jadwal_periksa', 'jadwal_periksa.id = daftar_poli.id_jadwal')
           ->join('dokter', 'dokter.dokter_id = jadwal_periksa.id_dokter')
           ->join('detail_periksa', 'detail_periksa.id_periksa = periksa.id', 'left')
           ->join('obat', 'obat.obat_id = detail_periksa.id_obat', 'left')
           ->where('jadwal_periksa.id_dokter', $dokter['dokter_id'])
           ->groupBy('periksa.id, daftar_poli.keluhan, daftar_poli.created_at, 
                     pasien.nama_pasien, pasien.no_rm, pasien.no_hp, 
                     dokter.nama_dokter')
           ->orderBy('periksa.tgl_periksa', 'DESC')
           ->get()
           ->getResultArray();

       return view('dokter/layout', [
           'title' => 'Riwayat Pasien',
           'content' => 'dokter/dashboard/riwayatPasien',
           'riwayatPeriksa' => $riwayatPeriksa
       ]);
   }
}