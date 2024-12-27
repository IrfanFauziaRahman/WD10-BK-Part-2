<?php

namespace App\Models;

use CodeIgniter\Model;

class DaftarPoliModel extends Model
{
    protected $table            = 'daftar_poli';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_pasien', 'id_jadwal', 'keluhan', 'no_antrian', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'id_pasien' => 'required|numeric',
        'id_jadwal' => 'required|numeric',
        'keluhan'   => 'required',
        'no_antrian'=> 'required|numeric',
    ];
    
    protected $validationMessages = [
        'id_pasien' => [
            'required' => 'ID Pasien harus diisi',
            'numeric' => 'ID Pasien harus berupa angka'
        ],
        'id_jadwal' => [
            'required' => 'ID Jadwal harus diisi',
            'numeric' => 'ID Jadwal harus berupa angka'
        ],
        'keluhan' => [
            'required' => 'Keluhan harus diisi'
        ],
        'no_antrian' => [
            'required' => 'Nomor antrian harus diisi',
            'numeric' => 'Nomor antrian harus berupa angka'
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Fungsi untuk mendapatkan riwayat pendaftaran poli pasien tertentu
    public function getRiwayatByPasien($id_pasien)
    {
        return $this->select('daftar_poli.*, 
                            poli.nama_poli, 
                            poli.keterangan,
                            dokter.nama_dokter, 
                            jadwal_periksa.hari, 
                            jadwal_periksa.jam_mulai, 
                            jadwal_periksa.jam_selesai,
                            pasien.nama_pasien,
                            pasien.no_hp as no_pasien,
                            pasien.no_rm')
            ->join('jadwal_periksa', 'jadwal_periksa.id = daftar_poli.id_jadwal')
            ->join('dokter', 'dokter.dokter_id = jadwal_periksa.id_dokter')
            ->join('poli', 'poli.poli_id = dokter.id_poli')
            ->join('pasien', 'pasien.pasien_id = daftar_poli.id_pasien')
            ->where('daftar_poli.id_pasien', $id_pasien)
            ->orderBy('daftar_poli.created_at', 'ASC')
            ->findAll();
    }

    // Fungsi untuk mendapatkan nomor antrian berikutnya
    public function getNextAntrian($id_jadwal)
    {
        $lastAntrian = $this->where('id_jadwal', $id_jadwal)
            ->orderBy('no_antrian', 'DESC')
            ->first();
            
        return $lastAntrian ? $lastAntrian['no_antrian'] + 1 : 1;
    }
}