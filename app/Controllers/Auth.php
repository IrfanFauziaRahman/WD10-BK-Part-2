<?php

// app/Controllers/Auth.php
namespace App\Controllers;

class Auth extends BaseController
{
    public function login()
    {
        // Handle login untuk Admin/Dokter/Pasien
    }
}

// app/Controllers/Admin.php
namespace App\Controllers;

class Admin extends BaseController
{
    public function index()
    {
        // Dashboard Admin
    }
    
    public function manageDokter()
    {
        // CRUD Dokter
    }
    
    public function managePasien()
    {
        // CRUD Pasien
    }
    
    public function managePoli()
    {
        // CRUD Poli
    }
    
    public function manageObat()
    {
        // CRUD Obat
    }
}