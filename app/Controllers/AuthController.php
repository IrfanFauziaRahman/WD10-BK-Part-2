<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PasienModel;
use DateTime;

class AuthController extends BaseController
{
    public function login()
    {
        if (session()->get('logged_in')) {
            $role = session()->get('role');
            if ($role === 'admin') {
                return redirect()->to('/admin/dashboard');
            } elseif ($role === 'dokter') {
                return redirect()->to('/dokter/dashboard');
            } elseif ($role === 'pasien') {
                return redirect()->to('/pasien/dashboard');
            }
        }
        
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
            if (password_verify($password, $user['password'])) {
                $session->set([
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                    'logged_in' => true,
                ]);

                if ($user['role'] === 'admin') {
                    return redirect()->to('/adminDashboard');
                } elseif ($user['role'] === 'dokter') {
                    return redirect()->to('/dokDashboard');
                } elseif ($user['role'] === 'pasien') {
                    return redirect()->to('/pasienDashboard');
                }
            } else {
                $session->setFlashdata('error', 'Password salah');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('error', 'Email tidak ditemukan');
            return redirect()->to('/login');
        }
    }

    public function register()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        return view('register');
    }

    public function registerAction()
    {
        log_message('debug', 'Starting registration process');
        log_message('debug', 'POST data: ' . print_r($this->request->getPost(), true));

        $rules = [
            'nama_pasien' => 'required|min_length[3]',
            'alamat' => 'required',
            'no_ktp' => 'required|numeric|min_length[16]|max_length[16]',
            'no_hp' => 'required|numeric|min_length[10]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            log_message('error', 'Validation failed: ' . print_r($this->validator->getErrors(), true));
            session()->setFlashdata('error', implode(', ', $this->validator->getErrors()));
            return redirect()->back()->withInput();
        }

        $userModel = new UserModel();
        $pasienModel = new PasienModel();

        $userData = [
            'name' => $this->request->getPost('nama_pasien'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => 'pasien'
        ];

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            log_message('debug', 'Attempting to insert user data');
            if (!$userModel->insert($userData)) {
                throw new \Exception('Failed to insert user: ' . implode(', ', $userModel->errors()));
            }
            
            $userId = $userModel->getInsertID();
            if (!$userId) {
                throw new \Exception('Failed to get user ID after insert');
            }
            log_message('debug', 'User inserted with ID: ' . $userId);

            $currentDate = new DateTime();
            $no_rm = $pasienModel->generateNoRM($currentDate);
            log_message('debug', 'Generated RM number: ' . $no_rm);

            $pasienData = [
                'nama_pasien' => $this->request->getPost('nama_pasien'),
                'alamat' => $this->request->getPost('alamat'),
                'no_ktp' => $this->request->getPost('no_ktp'),
                'no_hp' => $this->request->getPost('no_hp'),
                'no_rm' => $no_rm,
                'user_id' => $userId
            ];

            log_message('debug', 'Attempting to insert patient data');
            if (!$pasienModel->insert($pasienData)) {
                throw new \Exception('Failed to insert patient: ' . implode(', ', $pasienModel->errors()));
            }

            $db->transComplete();
            
            if ($db->transStatus() === false) {
                throw new \Exception('Transaction failed');
            }

            log_message('debug', 'Registration completed successfully');
            session()->setFlashdata('success', 'Registrasi berhasil! Silakan login.');
            return redirect()->to('/login');

        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Registration error: ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());
            session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
