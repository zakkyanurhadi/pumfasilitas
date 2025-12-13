<?php

namespace App\Models;

use CodeIgniter\Model;

class PrioritasModel extends Model
{
    protected $table            = 'prioritas';
    protected $primaryKey       = 'id_prioritas';
    protected $allowedFields    = ['nama_prioritas', 'level_prioritas', 'created_at'];

    protected $useTimestamps    = true;
}
