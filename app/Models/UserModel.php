<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    
    // SAYA TAMBAHKAN 'reset_token' DAN 'token_created_at' DI SINI:
    protected $allowedFields    = [
        'npm', 
        'nama', 
        'email', 
        'password', 
        'img', 
        'role', 
        'status',
        'reset_token',      // <--- Tambahan untuk Lupa Password
        'token_created_at'  // <--- Tambahan untuk Lupa Password
    ];
}