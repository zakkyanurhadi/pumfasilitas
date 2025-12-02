<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKeteranganVerifikasiToLaporan extends Migration
{
    public function up()
    {
        $this->forge->addColumn('laporan', [
            'keterangan_verifikasi' => [
                'type'       => 'TEXT',
                'null'       => true,
                'after'      => 'status' // opsional, bisa ditaruh setelah kolom 'status'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('laporan', 'keterangan_verifikasi');
    }
}
