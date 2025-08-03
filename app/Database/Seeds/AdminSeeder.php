<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username'     => 'admin',
                'nama_lengkap' => 'Farhan Maulana',
                'email'        => '8farhanmaulana@gmail.com',
                'password'     => password_hash('adminMCare505', PASSWORD_DEFAULT),
                'role'         => 1 // 1 = admin
            ]
        ];

        $this->db->table('tbl_user')->insertBatch($data);
    }
}
