<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLaporanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'npm' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'lokasi_kerusakan' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'lokasi_spesifik' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'kategori_kerusakan' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'tingkat_prioritas' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'deskripsi_kerusakan' => [
                'type' => 'TEXT',
            ],
            // --- PERBAIKAN DI SINI ---
            'foto_kerusakan' => [
                'type' => 'TEXT', // Diubah dari VARCHAR menjadi TEXT
                'null' => true,
            ],
            // -------------------------
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Pending', 'Diproses', 'Selesai'],
                'default'    => 'Pending',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('laporan');
    }

    public function down()
    {
        $this->forge->dropTable('laporan');
    }
}
