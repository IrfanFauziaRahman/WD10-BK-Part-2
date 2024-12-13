<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PoliModel;

class PoliController extends BaseController
{
    protected $poliModel;

    public function __construct()
    {
        $this->poliModel = new PoliModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Poliklinik Poli',
            'content' => 'admin/dashboard/poli',
            'poli' => $this->poliModel->findAll()
        ];

        return view('admin/layout', $data);
    }

    public function save()
    {
        $this->poliModel->save([
            'nama_poli' => $this->request->getPost('nama_poli'),
            'keterangan' => $this->request->getPost('keterangan'),
        ]);

        return redirect()->to('/admin/poli')->with('success', 'Data berhasil disimpan!');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Poli',
            'content' => 'admin/dashboard/poli',
            'poliData' => $this->poliModel->find($id), // Mengambil data poli berdasarkan ID
            'poli' => $this->poliModel->findAll()
        ];

        return view('admin/layout', $data);
    }

    public function update($id)
    {
        $this->poliModel->update($id, [
            'nama_poli' => $this->request->getPost('nama_poli'),
            'keterangan' => $this->request->getPost('keterangan'),
        ]);

        return redirect()->to('/admin/poli')->with('success', 'Data berhasil diperbarui!');
    }

    public function delete($id)
    {
        $this->poliModel->delete($id);
        return redirect()->to('/admin/poli')->with('success', 'Data berhasil dihapus!');
    }
}
