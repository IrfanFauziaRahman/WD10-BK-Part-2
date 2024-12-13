<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ObatModel;

class ObatController extends BaseController
{
    protected $obatModel;

    public function __construct()
    {
        $this->obatModel = new ObatModel();
    }

    // Halaman utama daftar obat
    public function index()
    {
        $data = [
            'title' => 'Daftar Obat',
            'content' => 'admin/dashboard/obat',
            'obat' => $this->obatModel->getAllObat()  // Mendapatkan semua data obat
        ];

        return view('admin/layout', $data);
    }

    // Menyimpan data obat baru
    public function save()
    {
        $this->obatModel->save([
            'nama_obat' => $this->request->getPost('nama_obat'),
            'kemasan' => $this->request->getPost('kemasan'),
            'harga' => $this->request->getPost('harga'),
        ]);

        return redirect()->to('/admin/obat')->with('success', 'Data obat berhasil disimpan!');
    }

    // Menampilkan halaman edit obat
    public function edit($id)
    {
        $data = [
            'title' => 'Edit Obat',
            'content' => 'admin/dashboard/obat',
            'obatData' => $this->obatModel->find($id),  // Mengambil data obat berdasarkan ID
            'obat' => $this->obatModel->getAllObat()   // Mendapatkan semua data obat
        ];

        return view('admin/layout', $data);
    }

    // Memperbarui data obat
    public function update($id)
    {
        $this->obatModel->update($id, [
            'nama_obat' => $this->request->getPost('nama_obat'),
            'kemasan' => $this->request->getPost('kemasan'),
            'harga' => $this->request->getPost('harga'),
        ]);

        return redirect()->to('/admin/obat')->with('success', 'Data obat berhasil diperbarui!');
    }

    // Menghapus data obat
    public function delete($id)
    {
        $this->obatModel->delete($id);
        return redirect()->to('/admin/obat')->with('success', 'Data obat berhasil dihapus!');
    }
}
