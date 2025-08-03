<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRoleAndUsernameToTblUser extends Migration
{
    public function up()
    {
        $fields = [
            'role' => [
                'type' => 'INT',
                'constraint' => 1,
                'default' => 2, // 1=admin, 2=user
                'after' => 'password',
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'after' => 'id_user',
                'unique' => true,
                'null' => true,
            ],
        ];
        $this->forge->addColumn('tbl_user', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_user', 'role');
        $this->forge->dropColumn('tbl_user', 'username');
    }
}
