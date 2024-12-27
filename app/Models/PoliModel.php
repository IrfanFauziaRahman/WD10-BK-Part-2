<?php
namespace App\Models;

use CodeIgniter\Model;

class PoliModel extends Model
{
    protected $table = 'poli';
    protected $primaryKey = 'poli_id';  
    protected $allowedFields = ['nama_poli', 'keterangan'];

    // Method untuk mendapatkan poli beserta jumlah dokternya
    public function getPoliWithDokterCount()
    {
        return $this->select('poli.*, COUNT(dokter.dokter_id) as jumlah_dokter')
                    ->join('dokter', 'dokter.id_poli = poli.poli_id', 'left')
                    ->groupBy('poli.poli_id')
                    ->findAll();
    }

    // Method untuk mendapatkan detail poli berdasarkan ID
    public function getPoliById($id)
    {
        return $this->find($id);
    }

    // Method untuk mendapatkan daftar dokter di suatu poli
    public function getDokterByPoli($poli_id)
    {
        return $this->select('dokter.*')
                    ->join('dokter', 'dokter.id_poli = poli.poli_id')
                    ->where('poli.poli_id', $poli_id)
                    ->findAll();
    }

    // Method untuk cek apakah poli memiliki dokter
    public function hasDokter($poli_id)
    {
        return $this->select('dokter.dokter_id')
                    ->join('dokter', 'dokter.id_poli = poli.poli_id')
                    ->where('poli.poli_id', $poli_id)
                    ->countAllResults() > 0;
    }
}