<?php
namespace App\Models;
use CodeIgniter\Model;

class RiwayatModel extends Model
{
    protected $table = 'periksa';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_daftar_poli', 'tgl_periksa', 'catatan', 'biaya_periksa'];

    public function getRiwayatByDokter($id_dokter)
    {
        return $this->select('periksa.*, daftar_poli.keluhan, daftar_poli.created_at, 
                            pasien.nama_pasien, pasien.no_rm, pasien.no_hp as no_pasien')
                    ->join('daftar_poli', 'daftar_poli.id = periksa.id_daftar_poli')
                    ->join('pasien', 'pasien.pasien_id = daftar_poli.id_pasien')
                    ->join('jadwal_periksa', 'jadwal_periksa.id = daftar_poli.id_jadwal')
                    ->where('jadwal_periksa.id_dokter', $id_dokter)
                    ->orderBy('periksa.tgl_periksa', 'DESC')
                    ->findAll();
    }

    public function getDetailRiwayat($id, $id_dokter)
    {
        return $this->select('periksa.*, daftar_poli.keluhan, daftar_poli.created_at, 
                            pasien.nama_pasien, pasien.no_rm, pasien.no_hp as no_pasien')
                    ->join('daftar_poli', 'daftar_poli.id = periksa.id_daftar_poli')
                    ->join('pasien', 'pasien.pasien_id = daftar_poli.id_pasien')
                    ->join('jadwal_periksa', 'jadwal_periksa.id = daftar_poli.id_jadwal')
                    ->where('periksa.id', $id)
                    ->where('jadwal_periksa.id_dokter', $id_dokter)
                    ->first();
    }
}