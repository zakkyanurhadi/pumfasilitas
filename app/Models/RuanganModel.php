<?php

namespace App\Models;

use CodeIgniter\Model;

class RuanganModel extends Model
{
    protected $table      = 'ruangan';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'gedung_id',
        'nama_ruangan',
        'lantai',
    ];

    public function getByGedung($gedungId)
    {
        return $this->where('gedung_id', $gedungId)->findAll();
    }
}
