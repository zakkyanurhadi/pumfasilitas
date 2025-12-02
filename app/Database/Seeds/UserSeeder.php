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
                'npm'      => 'admin',
                'nama'     => 'admingaul',
                'email'    => 'admin@gmail.com',
                'password' => password_hash('admin', PASSWORD_DEFAULT),
                'img'      => 'default.jpg',
                'role'     => 'admin'
            ],
        ];

        // Menggunakan Query Builder untuk memasukkan data
        $this->db->table('users')->insertBatch($data);
    }
}
