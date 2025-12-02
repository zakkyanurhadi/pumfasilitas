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
        $this->db->table('users')->insertBatch($data);
    }
}
