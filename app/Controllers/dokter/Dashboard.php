<?php
namespace App\Controllers\Dokter;
use App\Controllers\BaseController;
use App\Models\DokterModel;
use App\Models\MemeriksaModel;
use App\Models\DashboardModel;
use App\Models\JadwalPeriksaModel;

class Dashboard extends BaseController
{
    protected $dokterModel;
    protected $memeriksaModel;
    protected $dashboardModel;
    protected $jadwalModel;

    public function __construct()
    {
        $this->dokterModel = new DokterModel();
        $this->memeriksaModel = new MemeriksaModel();
        $this->dashboardModel = new DashboardModel();
        $this->jadwalModel = new JadwalPeriksaModel();
    }

    public function index()
    {
        $userId = session()->get('id');
        $dokter = $this->dokterModel->where('user_id', $userId)->first();
        
        if (!$dokter) {
            return redirect()->back()->with('error', 'Data dokter tidak ditemukan');
        }

        // Ambil data lengkap dokter termasuk nama poli
        $dokterData = $this->dokterModel->getDokterById($dokter['dokter_id']);
        
        $data = [
            'title' => 'Dashboard Dokter',
            'content' => 'dokter/dashboard/dokDashboard',
            'dokter' => $dokterData,
            'totalPasien' => $this->dashboardModel->getTotalPasienByDokter($dokter['dokter_id']),
            'antrianHariIni' => $this->dashboardModel->getAntrianHariIni($dokter['dokter_id']),
            'pasienSeminggu' => $this->dashboardModel->getPasienSeminggu($dokter['dokter_id']),
            'chartData' => $this->dashboardModel->getChartData($dokter['dokter_id'])
        ];
        
        return view('dokter/layout', $data);
    }
}