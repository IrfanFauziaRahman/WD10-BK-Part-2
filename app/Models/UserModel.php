<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 
        'email', 
        'password', 
        'remember_token', 
        'role', 
        'email_verified_at'
    ];
}
