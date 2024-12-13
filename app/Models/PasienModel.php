<?php

namespace App\Models;

use CodeIgniter\Model;

class PasienModel extends Model
{
    protected $table = 'pasien';
    protected $primaryKey = 'pasien_id';
    protected $allowedFields = ['nama_pasien', 'alamat', 'no_ktp', 'no_hp', 'no_rm', 'id_poli', 'user_id'];  // Adding 'id_poli' for consistency if needed

    // Method to retrieve all patient data with their associated poli name
    public function getAllPasien()
    {
        // Performing a join between pasien and poli tables
        return $this->select('pasien.pasien_id, pasien.nama_pasien, pasien.alamat, pasien.no_ktp, pasien.no_hp, pasien.no_rm, poli.nama_poli')
                    ->join('poli', 'pasien.id_poli = poli.poli_id')  // Joining the poli table based on the id_poli field
                    ->findAll();  // Fetch all the data
    }

    // Function to generate no_rm with the format YYYYMM-xxx
    public function generateNoRM($date)
    {
        // Format the date to get the year and month (YYYYMM)
        $yearMonth = $date->format('Ym');

        // Get the count of patients registered in that month
        $count = $this->where('no_rm LIKE', $yearMonth . '%')->countAllResults();

        // Generate the next patient number starting from 001
        $antrianNumber = str_pad($count + 1, 3, '0', STR_PAD_LEFT);

        // Return the no_rm in the format YYYYMM-xxx
        return $yearMonth . '-' . $antrianNumber;
    }

    public function getPasienWithUser($id = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('pasien.*, users.email');
        $builder->join('users', 'users.id = pasien.user_id', 'left');
        
        if ($id !== null) {
            return $builder->where('pasien_id', $id)->get()->getRowArray();
        }
        
        return $builder->get()->getResultArray();
    }
}
