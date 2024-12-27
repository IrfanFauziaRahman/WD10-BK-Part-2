<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalPeriksaModel extends Model
{
    protected $table = 'jadwal_periksa';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_dokter', 'hari', 'jam_mulai', 'jam_selesai', 'status'];
    protected $useTimestamps = false;
    protected $returnType = 'array';

    public function getJadwalWithDokter()
    {
        return $this->select('jadwal_periksa.*, dokter.nama_dokter, poli.nama_poli')
                    ->join('dokter', 'dokter.dokter_id = jadwal_periksa.id_dokter')
                    ->join('poli', 'poli.poli_id = dokter.id_poli')
                    ->findAll();
    }

    public function getJadwalByDokter($id_dokter)
    {
        return $this->select('jadwal_periksa.*, dokter.nama_dokter, poli.nama_poli')
                    ->join('dokter', 'dokter.dokter_id = jadwal_periksa.id_dokter')
                    ->join('poli', 'poli.poli_id = dokter.id_poli')
                    ->where('jadwal_periksa.id_dokter', $id_dokter)
                    ->findAll();
    }

    public function getActiveJadwal($dokter_id) 
    {
        return $this->where('id_dokter', $dokter_id)
                    ->where('status', 'Aktif')
                    ->first();
    }

    public function checkScheduleConflict($dokter_id, $hari, $jam_mulai, $jam_selesai, $jadwal_id = null) 
    {
        $builder = $this->where('id_dokter', $dokter_id)
                        ->where('hari', $hari)
                        ->where("(
                            (jam_mulai <= '$jam_mulai' AND jam_selesai > '$jam_mulai') OR
                            (jam_mulai < '$jam_selesai' AND jam_selesai >= '$jam_selesai') OR
                            ('$jam_mulai' <= jam_mulai AND '$jam_selesai' >= jam_selesai)
                        )");
        
        if ($jadwal_id) {
            $builder->where('id !=', $jadwal_id);
        }
        
        return $builder->first();
    }
}