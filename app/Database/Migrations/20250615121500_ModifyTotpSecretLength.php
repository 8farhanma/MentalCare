<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyTotpSecretLength extends Migration
{
    public function up()
    {
        $fields = [
            'totp_secret' => [
                'name'       => 'totp_secret',
                'type'       => 'VARCHAR',
                'constraint' => 128,
                'null'       => true,
            ],
        ];
        $this->forge->modifyColumn('tbl_user', $fields);
    }

    public function down()
    {
        $fields = [
            'totp_secret' => [
                'name'       => 'totp_secret',
                'type'       => 'VARCHAR',
                'constraint' => 64,
                'null'       => true,
            ],
        ];
        $this->forge->modifyColumn('tbl_user', $fields);
    }
}
