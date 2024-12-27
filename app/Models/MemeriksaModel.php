<?php

namespace App\Models;
use CodeIgniter\Model;

class MemeriksaModel extends Model
{
    protected $table = 'daftar_poli';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_pasien', 'id_jadwal', 'keluhan', 'no_antrian', 'status'];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Method untuk mendapatkan antrian pasien hari ini untuk dokter tertentu
    public function getAntrianHariIni($id_dokter)
    {
        $today = date('Y-m-d');
        return $this->select('daftar_poli.*, pasien.nama_pasien, pasien.no_rm')
                    ->join('jadwal_periksa', 'jadwal_periksa.id = daftar_poli.id_jadwal')
                    ->join('pasien', 'pasien.pasien_id = daftar_poli.id_pasien')
                    ->where('jadwal_periksa.id_dokter', $id_dokter)
                    ->where('DATE(daftar_poli.created_at)', $today)
                    ->where('daftar_poli.status', 'menunggu')
                    ->orderBy('daftar_poli.no_antrian', 'ASC')
                    ->findAll();
    }

    // Method untuk mendapatkan total antrian hari ini
    public function getTotalAntrianHariIni($id_dokter)
    {
        $today = date('Y-m-d');
        return $this->select('daftar_poli.*')
                    ->join('jadwal_periksa', 'jadwal_periksa.id = daftar_poli.id_jadwal')
                    ->where('jadwal_periksa.id_dokter', $id_dokter)
                    ->where('DATE(daftar_poli.created_at)', $today)
                    ->countAllResults();
    }

    // Method untuk mendapatkan antrian yang sedang diperiksa
    public function getAntrianDiperiksa($id_dokter)
    {
        $today = date('Y-m-d');
        return $this->select('daftar_poli.*, pasien.nama_pasien, pasien.no_rm')
                    ->join('jadwal_periksa', 'jadwal_periksa.id = daftar_poli.id_jadwal')
                    ->join('pasien', 'pasien.pasien_id = daftar_poli.id_pasien')
                    ->where('jadwal_periksa.id_dokter', $id_dokter)
                    ->where('DATE(daftar_poli.created_at)', $today)
                    ->where('daftar_poli.status', 'diperiksa')
                    ->get()
                    ->getRow();
    }

    // Method untuk mendapatkan riwayat antrian selesai hari ini
    public function getAntrianSelesai($id_dokter)
    {
        $today = date('Y-m-d');
        return $this->select('daftar_poli.*, pasien.nama_pasien, pasien.no_rm')
                    ->join('jadwal_periksa', 'jadwal_periksa.id = daftar_poli.id_jadwal')
                    ->join('pasien', 'pasien.pasien_id = daftar_poli.id_pasien')
                    ->where('jadwal_periksa.id_dokter', $id_dokter)
                    ->where('DATE(daftar_poli.created_at)', $today)
                    ->where('daftar_poli.status', 'selesai')
                    ->orderBy('daftar_poli.updated_at', 'DESC')
                    ->findAll();
    }

    // Method untuk mengupdate status antrian
    public function updateStatus($id, $status)
    {
        return $this->update($id, ['status' => $status]);
    }

    // Method untuk mendapatkan detail antrian
    public function getDetailAntrian($id)
    {
        return $this->select('daftar_poli.*, pasien.*, jadwal_periksa.*, dokter.nama_dokter, poli.nama_poli')
                    ->join('pasien', 'pasien.pasien_id = daftar_poli.id_pasien')
                    ->join('jadwal_periksa', 'jadwal_periksa.id = daftar_poli.id_jadwal')
                    ->join('dokter', 'dokter.dokter_id = jadwal_periksa.id_dokter')
                    ->join('poli', 'poli.poli_id = dokter.id_poli')
                    ->where('daftar_poli.id', $id)
                    ->first();
    }


// Di dalam class MemeriksaModel
public function getDaftarPoliByDokter($id_dokter)
{
    return $this->select('daftar_poli.*, pasien.nama_pasien, pasien.no_rm')
                ->join('jadwal_periksa', 'jadwal_periksa.id = daftar_poli.id_jadwal')
                ->join('pasien', 'pasien.pasien_id = daftar_poli.id_pasien')
                ->where('jadwal_periksa.id_dokter', $id_dokter)
                ->orderBy('daftar_poli.created_at', 'ASC')
                ->findAll();
}

public function getDaftarPoliDetail($id)
{
    return $this->select('daftar_poli.*, pasien.nama_pasien, pasien.no_rm, pasien.no_hp, jadwal_periksa.id_dokter')
                ->join('jadwal_periksa', 'jadwal_periksa.id = daftar_poli.id_jadwal')
                ->join('pasien', 'pasien.pasien_id = daftar_poli.id_pasien')
                ->where('daftar_poli.id', $id)
                ->first();
}

}
