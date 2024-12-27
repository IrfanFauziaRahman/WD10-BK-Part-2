<?php
namespace App\Models;
use CodeIgniter\Model;

class DashboardModel extends Model
{
    public function getTotalPasienByDokter($id_dokter)
    {
        $db = \Config\Database::connect();
        return $db->table('daftar_poli')
                 ->join('jadwal_periksa', 'jadwal_periksa.id = daftar_poli.id_jadwal')
                 ->where('jadwal_periksa.id_dokter', $id_dokter)
                 ->countAllResults();
    }

    public function getAntrianHariIni($id_dokter)
    {
        $db = \Config\Database::connect();
        $today = date('Y-m-d');
        
        return $db->table('daftar_poli')
                 ->join('jadwal_periksa', 'jadwal_periksa.id = daftar_poli.id_jadwal')
                 ->join('pasien', 'pasien.pasien_id = daftar_poli.id_pasien')
                 ->where('jadwal_periksa.id_dokter', $id_dokter)
                 ->where('DATE(daftar_poli.created_at)', $today)
                 ->where('daftar_poli.status', 'menunggu')
                 ->select('daftar_poli.*, pasien.nama_pasien, pasien.no_rm')
                 ->orderBy('daftar_poli.no_antrian', 'ASC')
                 ->get()
                 ->getResultArray();
    }

    public function getPasienSeminggu($id_dokter)
    {
        $db = \Config\Database::connect();
        $weekAgo = date('Y-m-d', strtotime('-7 days'));
        
        return $db->table('periksa')
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
}