<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PasienModel;
use App\Models\UserModel;
use DateTime;

class PasienController extends BaseController
{
    protected $pasienModel;
    protected $userModel;
    protected $db;

    public function __construct()
    {
        $this->pasienModel = new PasienModel();
        $this->userModel = new UserModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $builder = $this->db->table('pasien');
        $builder->select('pasien.*, users.email');
        $builder->join('users', 'users.id = pasien.user_id');
        $pasien = $builder->get()->getResultArray();

        $data = [
            'title' => 'Kelola Data Pasien',
            'content' => 'admin/dashboard/adminPasien',
            'pasien' => $pasien
        ];

        return view('admin/layout', $data);
    }

    public function save()
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            // 1. Persiapkan data user
            $userData = [
                'name' => $this->request->getPost('nama_pasien'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'role' => 'pasien'
            ];

            // 2. Insert data user
            $this->userModel->save($userData);
            $userId = $this->userModel->getInsertID();

            // 3. Generate nomor rekam medis
            $currentDate = new DateTime();
            $yearMonth = $currentDate->format('Ym');
            
            $lastRM = $this->db->table('pasien')
                              ->like('no_rm', $yearMonth, 'after')
                              ->orderBy('no_rm', 'DESC')
                              ->get()
                              ->getRow();
                              
            $sequence = '001';
            if ($lastRM) {
                $lastSequence = substr($lastRM->no_rm, -3);
                $sequence = str_pad((int)$lastSequence + 1, 3, '0', STR_PAD_LEFT);
            }
            
            $no_rm = $yearMonth . '-' . $sequence;

            // 4. Persiapkan data pasien
            $pasienData = [
                'nama_pasien' => $this->request->getPost('nama_pasien'),
                'alamat' => $this->request->getPost('alamat'),
                'no_ktp' => $this->request->getPost('no_ktp'),
                'no_hp' => $this->request->getPost('no_hp'),
                'no_rm' => $no_rm,
                'user_id' => $userId
            ];

            // 5. Insert data pasien
            $this->pasienModel->save($pasienData);

            // 6. Commit transaksi jika semua berhasil
            if ($db->transStatus() === false) {
                $db->transRollback();
                return redirect()->to('/admin/pasien')
                    ->with('error', 'Gagal menyimpan data')
                    ->withInput();
            }

            $db->transCommit();
            return redirect()->to('/admin/pasien')
                ->with('success', 'Data pasien berhasil disimpan');

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->to('/admin/pasien')
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        try {
            // 1. Ambil data pasien beserta data user
            $builder = $this->db->table('pasien');
            $builder->select('pasien.*, users.email, users.id as user_id');
            $builder->join('users', 'users.id = pasien.user_id');
            $builder->where('pasien.pasien_id', $id);
            $pasien = $builder->get()->getRowArray();

            if (!$pasien) {
                throw new \Exception('Data pasien tidak ditemukan');
            }

            // 2. Ambil semua data pasien untuk tabel
            $allPasien = $this->db->table('pasien')
                                 ->select('pasien.*, users.email')
                                 ->join('users', 'users.id = pasien.user_id')
                                 ->get()
                                 ->getResultArray();

            // 3. Siapkan data untuk view
            $data = [
                'title' => 'Edit Pasien',
                'content' => 'admin/dashboard/adminPasien',
                'pasienData' => $pasien,
                'userData' => [
                    'id' => $pasien['user_id'],
                    'email' => $pasien['email']
                ],
                'pasien' => $allPasien
            ];

            return view('admin/layout', $data);
            
        } catch (\Exception $e) {
            return redirect()->to('/admin/pasien')
                ->with('error', $e->getMessage());
        }
    }

    public function update($id)
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            // 1. Ambil data pasien
            $pasien = $this->pasienModel->find($id);
            if (!$pasien) {
                throw new \Exception('Data pasien tidak ditemukan');
            }

            // 2. Update data pasien
            $pasienData = [
                'pasien_id' => $id,
                'nama_pasien' => $this->request->getPost('nama_pasien'),
                'alamat' => $this->request->getPost('alamat'),
                'no_ktp' => $this->request->getPost('no_ktp'),
                'no_hp' => $this->request->getPost('no_hp')
            ];
            
            $this->pasienModel->save($pasienData);

            // 3. Update data user
            $userData = [
                'id' => $pasien['user_id'],
                'name' => $this->request->getPost('nama_pasien'),
                'email' => $this->request->getPost('email')
            ];

            // Update password jika diisi
            if (!empty($this->request->getPost('password'))) {
                $userData['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
            }

            $this->userModel->save($userData);

            // 4. Commit transaksi jika semua berhasil
            if ($db->transStatus() === false) {
                $db->transRollback();
                return redirect()->to('/admin/pasien')
                    ->with('error', 'Gagal mengupdate data')
                    ->withInput();
            }

            $db->transCommit();
            return redirect()->to('/admin/pasien')
                ->with('success', 'Data pasien berhasil diupdate');

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->to('/admin/pasien')
                ->with('error', 'Gagal mengupdate data: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            // 1. Ambil data pasien
            $pasien = $this->pasienModel->find($id);
            if (!$pasien) {
                throw new \Exception('Data pasien tidak ditemukan');
            }

            // 2. Hapus data pasien
            $this->pasienModel->delete($id);

            // 3. Hapus data user
            $this->userModel->delete($pasien['user_id']);

            // 4. Commit transaksi jika semua berhasil
            if ($db->transStatus() === false) {
                $db->transRollback();
                return redirect()->to('/admin/pasien')
                    ->with('error', 'Gagal menghapus data');
            }

            $db->transCommit();
            return redirect()->to('/admin/pasien')
                ->with('success', 'Data pasien berhasil dihapus');

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->to('/admin/pasien')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}