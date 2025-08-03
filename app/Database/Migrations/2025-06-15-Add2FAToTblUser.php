<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Add2FAToTblUser extends Migration
{
    public function up()
    {
        $fields = [
            'totp_secret' => [
                'type'       => 'VARCHAR',
                'constraint' => 64,
                'null'       => true,
                'after'      => 'role'
            ],
            'is_2fa_enabled' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'totp_secret'
            ]
        ];
        $this->forge->addColumn('tbl_user', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_user', ['totp_secret', 'is_2fa_enabled']);
    }
}
