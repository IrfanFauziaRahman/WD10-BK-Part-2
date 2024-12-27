<?php

namespace App\Models;
use CodeIgniter\Model;

class PeriksaModel extends Model
{
    protected $table = 'periksa';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_daftar_poli', 'tgl_periksa', 'catatan', 'biaya_periksa'];

    public function getTotalPasienByDokter($id_dokter)
{
    return $this->select('periksa.*')
                ->join('daftar_poli', 'daftar_poli.id = periksa.id_daftar_poli')
                ->join('jadwal_periksa', 'jadwal_periksa.id = daftar_poli.id_jadwal')
                ->where('jadwal_periksa.id_dokter', $id_dokter)
                ->countAllResults();
}

public function getPasienSeminggu($id_dokter)
{
    $weekAgo = date('Y-m-d', strtotime('-7 days'));
    return $this->select('periksa.*')
                ->join('daftar_poli', 'daftar_poli.id = periksa.id_daftar_poli')
                ->join('jadwal_periksa', 'jadwal_periksa.id = daftar_poli.id_jadwal')
                ->where('jadwal_periksa.id_dokter', $id_dokter)
                ->where('periksa.tgl_periksa >=', $weekAgo)
                ->countAllResults();
}

public function getChartData($id_dokter)
{
    $db = \Config\Database::connect();
    $weekAgo = date('Y-m-d', strtotime('-7 days'));
    $today = date('Y-m-d');
    
    $query = $db->query("
        SELECT DATE(p.tgl_periksa) as tanggal, COUNT(*) as total
        FROM periksa p
        JOIN daftar_poli dp ON dp.id = p.id_daftar_poli
        JOIN jadwal_periksa jp ON jp.id = dp.id_jadwal
        WHERE jp.id_dokter = $id_dokter 
        AND p.tgl_periksa BETWEEN '$weekAgo' AND '$today'
        GROUP BY DATE(p.tgl_periksa)
        ORDER BY tanggal ASC
    ");

    $result = $query->getResultArray();
    
    $data = [];
    $labels = [];
    
    // Generate data for last 7 days
    for($i = 6; $i >= 0; $i--) {
        $date = date('Y-m-d', strtotime("-$i days"));
        $labels[] = date('D', strtotime($date));
        
        $found = false;
        foreach($result as $row) {
            if($row['tanggal'] == $date) {
                $data[] = (int)$row['total'];
                $found = true;
                break;
            }
        }
        
        if(!$found) {
            $data[] = 0;
        }
    }
    
    return [
        'labels' => $labels,
        'data' => $data
    ];
}

public function getDetailObat($id_periksa)
{
    return $this->db->table('detail_periksa')
                    ->select('detail_periksa.*, obat.*')
                    ->join('obat', 'obat.obat_id = detail_periksa.id_obat')
                    ->where('detail_periksa.id_periksa', $id_periksa)
                    ->get()
                    ->getResultArray();
}
}

