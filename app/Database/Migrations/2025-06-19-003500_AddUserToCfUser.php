<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserToCfUser extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_cf_user', [
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true, // Allow null in case some old records don't have a user
                'after' => 'id_cf_user',
            ],
        ]);

        // It's good practice to add a foreign key constraint
        // Note: This assumes tbl_user and id_user exist and are compatible.
        $this->forge->addForeignKey('id_user', 'tbl_user', 'id_user', 'CASCADE', 'SET NULL');
        $this->forge->processIndexes('tbl_cf_user');
    }

    public function down()
    {
        $this->forge->dropForeignKey('tbl_cf_user', 'tbl_cf_user_id_user_foreign');
        $this->forge->dropColumn('tbl_cf_user', 'id_user');
    }
}
