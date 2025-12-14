<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Data pengguna yang akan dimasukkan
        $data = [

            [
                'npm'      => 'damarr',
                'nama'     => 'damar',
                'email'    => 'damar@gmail.com',
                'password' => password_hash('Damar123', PASSWORD_DEFAULT),
                'img'      => 'default.jpg',
                'role'     => 'user'
            ],
        ];

        // Menggunakan Query Builder untuk memasukkan data
        $data = [
            // USER / MAHASISWA
            [
                'npm'      => '2023000001',
                'nama'     => 'Mahasiswa Satu',
                'email'    => 'mahasiswa1@gmail.com',
                'password' => password_hash('user123', PASSWORD_DEFAULT),
                'img'      => 'default.png',
                'role'     => 'user',
                'status'   => 'active',
            ],

            // ADMIN
            [
                'npm'      => 'admin001',
                'nama'     => 'Admin Fasilitas',
                'email'    => 'admin@gmail.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'img'      => 'default.png',
                'role'     => 'admin',
                'status'   => 'active',
            ],

            // SUPERADMIN
            [
                'npm'      => 'superadmin01',
                'nama'     => 'Super Administrator',
                'email'    => 'superadmin@gmail.com',
                'password' => password_hash('superadmin123', PASSWORD_DEFAULT),
                'img'      => 'default.png',
                'role'     => 'superadmin',
                'status'   => 'active',
            ],

            // REKTOR (READ ONLY)
            [
                'npm'      => 'rektor01',
                'nama'     => 'Rektor Kampus',
                'email'    => 'rektor@gmail.com',
                'password' => password_hash('rektor123', PASSWORD_DEFAULT),
                'img'      => 'default.png',
                'role'     => 'rektor',
                'status'   => 'active',
            ],
        ];

        // Insert data
        $this->db->table('users')->insertBatch($data);
    }
}
