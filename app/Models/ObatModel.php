<?php

namespace App\Models;

use CodeIgniter\Model;

class ObatModel extends Model
{
    protected $table = 'obat';
    protected $primaryKey = 'obat_id';  // Primary key untuk obat
    protected $allowedFields = ['nama_obat', 'kemasan', 'harga'];

    // Fungsi untuk mendapatkan data semua obat
    public function getAllObat()
    {
        return $this->findAll();
    }
}
