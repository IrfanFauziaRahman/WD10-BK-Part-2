<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;


class Dashboard extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Admin Dashboard',
            'content' => 'admin/dashboard/adminDashboard', // ini menunjuk ke view poli.php
        ];
        
        return view('admin/layout', $data); // Memanggil layout.php
    }
}
