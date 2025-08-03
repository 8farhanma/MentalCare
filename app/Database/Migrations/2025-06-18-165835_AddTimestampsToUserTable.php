<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTimestampsToUserTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_user', [
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_user', ['created_at', 'updated_at']);
    }
}
