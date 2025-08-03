<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'email' => 'UserTest@gmail.com',
                'nama_lengkap' => 'User 1',
                'password' => password_hash('User.123', PASSWORD_DEFAULT)
            ]
        ];

        $this->db->table('tbl_user')->insertBatch($data);
    }
}
