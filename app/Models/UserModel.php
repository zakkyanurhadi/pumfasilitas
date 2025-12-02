<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['npm', 'nama', 'email', 'password', 'img'];
    protected $useTimestamps    = false;
}
