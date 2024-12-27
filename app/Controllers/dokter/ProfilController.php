<?php
namespace App\Controllers\Dokter;
use App\Controllers\BaseController;
use App\Models\DokterModel;

class ProfilController extends BaseController
{
    protected $dokterModel;
    protected $session;

    public function __construct()
    {
        $this->dokterModel = new DokterModel();
        $this->session = session();
    }

    public function index()
    {
        $userId = $this->session->get('user_id');
        if (!$userId) {
            $userId = $this->session->get('id');
        }
        
        $dokter = $this->dokterModel->where('user_id', $userId)->first();

        $data = [
            'title' => 'Profil Dokter',
            'content' => 'dokter/dashboard/profil',
            'dokter' => $dokter,
            'userId' => $userId
        ];
        
        return view('dokter/layout', $data);
    }

    public function update()
    {
        $userId = $this->session->get('user_id');
        if (!$userId) {
            $userId = $this->session->get('id');
        }

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Sesi telah berakhir, silakan login kembali');
        }
        
        $rules = [
            'nama_dokter' => 'required|min_length[3]',
            'alamat' => 'required',
            'no_hp' => 'required|min_length[10]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        try {
            $dokter = $this->dokterModel->where('user_id', $userId)->first();
            
            if (!$dokter) {
                return redirect()->back()->with('error', 'Data dokter tidak ditemukan');
            }

            $noHp = preg_replace('/[^0-9]/', '', $this->request->getPost('no_hp'));
            
            $data = [
                'nama_dokter' => $this->request->getPost('nama_dokter'),
                'alamat' => $this->request->getPost('alamat'),
                'no_hp' => (int)$noHp
            ];

            $updated = $this->dokterModel->update($dokter['dokter_id'], $data);
            
            if ($updated) {
                return redirect()->to('/dokter/profil')->with('success', 'Profil berhasil diperbarui');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal memperbarui profil');
            }

        } catch (\Exception $e) {
            log_message('error', 'Error updating doctor profile: ' . $e->getMessage());
            return redirect()->back()->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui profil. Silakan coba lagi.');
        }
    }
}