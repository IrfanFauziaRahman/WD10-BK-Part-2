<?php
namespace App\Models;

use CodeIgniter\Model;

class PoliModel extends Model
{
    protected $table = 'poli';
    protected $primaryKey = 'poli_id';  // Menggunakan poli_id sebagai primary key
    protected $allowedFields = ['nama_poli', 'keterangan'];
}
