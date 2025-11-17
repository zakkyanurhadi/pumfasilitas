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
<<<<<<< HEAD
                'npm'      => 'pengguna',
                'nama'     => 'pengguna',
                'email'    => 'pengguna@gmail.com',
=======
                'npm'      => 'user',
                'nama'     => 'user',
                'email'    => 'user@gmail.com',
>>>>>>> a021c53d3d5052bd35c536551069be25ab0e4265
                'password' => password_hash('user', PASSWORD_DEFAULT),
                'img'      => 'default.jpg',
                'role'     => 'users'
            ],
        ];

        // Menggunakan Query Builder untuk memasukkan data
        $this->db->table('users')->insertBatch($data);
    }
}
