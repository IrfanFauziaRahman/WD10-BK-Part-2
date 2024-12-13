<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PasienModel;
use DateTime;

class AuthController extends BaseController
{
    public function login()
    {
        // Tampilkan halaman login
        return view('login');
    }

    public function auth()
    {
        $session = session();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if ($user) {
            // Verifikasi password
            if (password_verify($password, $user['password'])) {
                // Set data sesi pengguna
                $session->set([
                    'user_id' => $user['id'],
                    'user_name' => $user['name'],
                    'user_role' => $user['role'],
                    'logged_in' => true,
                ]);

                // Redirect berdasarkan peran
                if ($user['role'] === 'admin') {
                    return redirect()->to('/admin/dashboard');
                } elseif ($user['role'] === 'dokter') {
                    return redirect()->to('/dokter/dashboard');
                } elseif ($user['role'] === 'pasien') {
                    return redirect()->to('/pasien/dashboard');
                }
            } else {
                // Password salah
                $session->setFlashdata('error', 'Password salah.');
            }
        } else {
            // Email tidak ditemukan
            $session->setFlashdata('error', 'Email tidak ditemukan.');
        }

        return redirect()->to('/login');
    }

    public function logout()
    {
        // Hancurkan sesi dan redirect ke login
        session()->destroy();
        return redirect()->to('/login');
    }

    public function register()
    {
        // Tampilkan halaman register
        return view('register');
    }

    public function registerAction()
{
    $request = $this->request;
    $session = session();

    // Ambil data pasien
    $pasienData = [
        'nama_pasien' => $request->getPost('nama_pasien'),
        'alamat' => $request->getPost('alamat'),
        'no_ktp' => $request->getPost('no_ktp'),
        'no_hp' => $request->getPost('no_hp')
    ];

    // Inisialisasi model pasien dan simpan data pasien
    $pasienModel = new PasienModel();
    $currentDate = new DateTime();
    $no_rm = $pasienModel->generateNoRM($currentDate);
    $pasienData['no_rm'] = $no_rm;

    // Simpan data user untuk pasien
    $userData = [
        'name' => $request->getPost('nama_pasien'),
        'email' => $request->getPost('email'),
        'password' => password_hash($request->getPost('password'), PASSWORD_BCRYPT), // Hash password
        'role' => 'pasien'
    ];

    // Inisialisasi model user dan simpan data user
    $userModel = new UserModel();
    $userModel->save($userData);

    // Ambil ID user yang baru saja disimpan
    $userId = $userModel->insertID();

    // Tambahkan user_id ke data pasien
    $pasienData['user_id'] = $userId;

    // Simpan data pasien
    $pasienModel->save($pasienData);

    // Set flash data untuk success
    $session->setFlashdata('success', 'Pendaftaran berhasil! Silakan login.');

    return redirect()->to('/login'); // Redirect ke halaman login setelah pendaftaran sukses
}

}
