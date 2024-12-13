<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DokterModel;
use App\Models\PoliModel;
use App\Models\UserModel;

class DokterController extends BaseController
{
    protected $dokterModel;
    protected $poliModel;
    protected $userModel;

    public function __construct()
    {
        $this->dokterModel = new DokterModel();
        $this->poliModel = new PoliModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $dokter = $this->dokterModel->findAll();
        foreach ($dokter as &$d) {
            $d['nama_poli'] = $this->poliModel->find($d['id_poli'])['nama_poli'] ?? '-';
        }

        $data = [
            'title' => 'Kelola Dokter',
            'content' => 'admin/dashboard/adminDokter',
            'dokter' => $dokter,
            'poli' => $this->poliModel->findAll(),
        ];

        return view('admin/layout', $data);
    }

    public function save()
{
    $db = \Config\Database::connect();
    $db->transStart(); // Mulai transaksi

    try {
        // Validasi input terlebih dahulu
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_dokter' => 'required',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'alamat' => 'required',
            'no_hp' => 'required',
            'id_poli' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->to('/admin/dokter')
                           ->with('error', 'Validasi gagal: ' . implode(', ', $validation->getErrors()));
        }

        // Simpan data user
        $userData = [
            'name' => $this->request->getPost('nama_dokter'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => 'dokter'
        ];

        // Menggunakan query builder untuk insert user
        $builder = $db->table('users');
        $builder->insert($userData);
        
        // Dapatkan ID user yang baru saja diinsert
        $userId = $db->insertID();

        if (!$userId) {
            throw new \Exception('Gagal menyimpan data user');
        }

        // Simpan data dokter
        $dokterData = [
            'nama_dokter' => $this->request->getPost('nama_dokter'),
            'alamat' => $this->request->getPost('alamat'),
            'no_hp' => $this->request->getPost('no_hp'),
            'id_poli' => $this->request->getPost('id_poli'),
            'user_id' => $userId
        ];

        // Menggunakan query builder untuk insert dokter
        $builder = $db->table('dokter');
        $builder->insert($dokterData);

        $db->transComplete();

        if ($db->transStatus() === false) {
            // Jika transaksi gagal, rollback akan dilakukan otomatis
            return redirect()->to('/admin/dokter')
                           ->with('error', 'Transaksi gagal. Data tidak tersimpan.');
        }

        return redirect()->to('/admin/dokter')
                       ->with('success', 'Data dokter berhasil disimpan.');

    } catch (\Exception $e) {
        $db->transRollback();
        return redirect()->to('/admin/dokter')
                       ->with('error', 'Error: ' . $e->getMessage());
    }
}

public function edit($id)
{
    try {
        // Ambil data dokter yang akan diedit
        $dokter = $this->dokterModel->find($id);
        if (!$dokter) {
            throw new \Exception('Data dokter tidak ditemukan');
        }

        // Ambil data user
        $user = $this->userModel->find($dokter['user_id']);
        if (!$user) {
            throw new \Exception('Data user tidak ditemukan');
        }

        // Ambil semua data dokter untuk ditampilkan di tabel
        $allDokter = $this->dokterModel->findAll();
        foreach ($allDokter as &$d) {
            $d['nama_poli'] = $this->poliModel->find($d['id_poli'])['nama_poli'] ?? '-';
        }
        
        $data = [
            'title' => 'Edit Dokter',
            'content' => 'admin/dashboard/adminDokter',
            'dokterData' => $dokter,
            'userData' => $user,
            'poli' => $this->poliModel->findAll(),
            'dokter' => $allDokter  // Menambahkan semua data dokter untuk tabel
        ];

        return view('admin/layout', $data);
    } catch (\Exception $e) {
        return redirect()->to('/admin/dokter')->with('error', $e->getMessage());
    }
}

public function update($id)
{
    $db = \Config\Database::connect();
    $db->transStart();

    try {
        // Ambil data dokter yang akan diupdate
        $dokter = $this->dokterModel->find($id);
        
        // Update data dokter
        $dokterData = [
            'dokter_id' => $id,
            'nama_dokter' => $this->request->getPost('nama_dokter'),
            'alamat' => $this->request->getPost('alamat'),
            'no_hp' => $this->request->getPost('no_hp'),
            'id_poli' => $this->request->getPost('id_poli'),
        ];
        $this->dokterModel->save($dokterData);

        // Update data user menggunakan user_id dari data dokter
        $userData = [
            'id' => $dokter['user_id'], // Pastikan id user dimasukkan
            'name' => $this->request->getPost('nama_dokter'),
            'email' => $this->request->getPost('email'),
        ];

        // Jika password diisi, tambahkan ke userData
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $userData['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        $this->userModel->save($userData);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->to('/admin/dokter')->with('error', 'Gagal mengupdate data dokter.');
        }

        return redirect()->to('/admin/dokter')->with('success', 'Data dokter berhasil diperbarui.');

    } catch (\Exception $e) {
        $db->transRollback();
        return redirect()->to('/admin/dokter')->with('error', 'Error: ' . $e->getMessage());
    }
}
    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            // 1. Ambil data dokter
            $dokter = $this->dokterModel->find($id);
            if (!$dokter) {
                throw new \Exception('Data dokter tidak ditemukan');
            }

            // 2. Hapus data dokter
            $this->dokterModel->delete($id);

            // 3. Hapus data user berdasarkan nama dokter
            $this->userModel->where('name', $dokter['nama_dokter'])->delete();

            // 4. Commit transaksi jika semua berhasil
            if ($db->transStatus() === false) {
                $db->transRollback();
                return redirect()->to('/admin/dokter')
                    ->with('error', 'Gagal menghapus data');
            }

            $db->transCommit();
            return redirect()->to('/admin/dokter')
                ->with('success', 'Data dokter berhasil dihapus');

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->to('/admin/dokter')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}