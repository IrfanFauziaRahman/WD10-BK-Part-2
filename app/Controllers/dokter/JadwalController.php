<?php

namespace App\Controllers\Dokter;
use App\Controllers\BaseController;
use App\Models\JadwalPeriksaModel;
use App\Models\DokterModel;

class JadwalController extends BaseController
{
    protected $jadwalModel;
    protected $dokterModel;

    public function __construct()
    {
        $this->jadwalModel = new JadwalPeriksaModel();
        $this->dokterModel = new DokterModel();
    }

    public function index()
    {
        $user_id = session()->get('id');
        $dokter = $this->dokterModel->where('user_id', $user_id)->first();

        if (!$dokter) {
            return redirect()->back()->with('error', 'Data dokter tidak ditemukan');
        }

        $data = [
            'title' => 'Jadwal Periksa',
            'content' => 'dokter/dashboard/jadwal',
            'jadwalPeriksa' => $this->jadwalModel->getJadwalByDokter($dokter['dokter_id']),
            'doctors' => [$dokter],
            'dokter_id' => $dokter['dokter_id']
        ];
        
        return view('dokter/layout', $data);
    }

    public function create()
    {
        if (!$this->request->is('post')) {
            return redirect()->to('/dokter/jadwal');
        }

        $rules = [
            'id_dokter' => 'required|numeric',
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'status' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $this->validator->getErrors());
        }

        $userId = session()->get('id');
        $dokter = $this->dokterModel->where('user_id', $userId)->first();
        
        if ($dokter['dokter_id'] != $this->request->getPost('id_dokter')) {
            return redirect()->back()
                           ->withInput()
                           ->with('errors', ['Anda tidak memiliki akses untuk menambah jadwal dokter lain']);
        }

        $dokter_id = $this->request->getPost('id_dokter');
        $hari = $this->request->getPost('hari');
        $jam_mulai = $this->request->getPost('jam_mulai');
        $jam_selesai = $this->request->getPost('jam_selesai');
        $status = $this->request->getPost('status');

        // Check schedule conflict
        if ($this->jadwalModel->checkScheduleConflict($dokter_id, $hari, $jam_mulai, $jam_selesai)) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Jadwal bertabrakan dengan jadwal yang sudah ada');
        }

        // If status is Aktif, deactivate other schedules
        if ($status === 'Aktif') {
            $this->jadwalModel->where('id_dokter', $dokter_id)
                             ->set(['status' => 'Tidak Aktif'])
                             ->update();
        }

        try {
            $this->jadwalModel->insert([
                'id_dokter' => $dokter_id,
                'hari' => $hari,
                'jam_mulai' => $jam_mulai,
                'jam_selesai' => $jam_selesai,
                'status' => $status
            ]);
            return redirect()->to('/dokter/jadwal')
                           ->with('success', 'Jadwal berhasil ditambahkan');
        } catch (\Exception $e) {
            log_message('error', '[JadwalController::create] Error: ' . $e->getMessage());
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal menambahkan jadwal. Silakan coba lagi.');
        }
    }

    public function update($id = null)
    {
        if (!$this->request->is('post') || !$id) {
            return redirect()->to('/dokter/jadwal');
        }

        $rules = [
            'id_dokter' => 'required|numeric',
            'status' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $this->validator->getErrors());
        }

        $userId = session()->get('id');
        $dokter = $this->dokterModel->where('user_id', $userId)->first();
        
        if ($dokter['dokter_id'] != $this->request->getPost('id_dokter')) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Anda tidak memiliki akses untuk mengubah jadwal ini');
        }

        $dokter_id = $this->request->getPost('id_dokter');
        $status = $this->request->getPost('status');

        try {
            // If setting to active, deactivate all other schedules first
            if ($status === 'Aktif') {
                $this->jadwalModel->where('id_dokter', $dokter_id)
                                 ->where('id !=', $id)
                                 ->set(['status' => 'Tidak Aktif'])
                                 ->update();
            }

            $updated = $this->jadwalModel->update($id, [
                'status' => $status
            ]);
            
            if ($updated) {
                return redirect()->to('/dokter/jadwal')
                               ->with('success', 'Status jadwal berhasil diupdate');
            }
            throw new \Exception('Update failed');
        } catch (\Exception $e) {
            log_message('error', '[JadwalController::update] Error: ' . $e->getMessage());
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal mengupdate status jadwal');
        }
    }

    protected function getDokterByUserId($userId)
    {
        return $this->dokterModel->where('user_id', $userId)->first();
    }

    protected function validateDokterAccess($dokterId)
    {
        $userId = session()->get('id');
        $dokter = $this->getDokterByUserId($userId);
        
        if (!$dokter || $dokter['dokter_id'] != $dokterId) {
            return false;
        }
        
        return true;
    }
}