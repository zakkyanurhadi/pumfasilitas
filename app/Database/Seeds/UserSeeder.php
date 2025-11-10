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
                'npm'      => 'user',
                'nama'     => 'user',
                'email'    => 'user@gmail.com',
                'password' => password_hash('user', PASSWORD_DEFAULT),
                'img'      => 'default.jpg',
                'role'     => 'users'
            ],
        ];

        // Menggunakan Query Builder untuk memasukkan data
        $this->db->table('users')->insertBatch($data);
    }
}
