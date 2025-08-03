<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserToDiagnosis extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_diagnosis', [
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'id_diagnosis',
            ],
        ]);

        // Adding a foreign key is best practice
        // This assumes tbl_user exists and has an id_user primary key
        $this->forge->addForeignKey('id_user', 'tbl_user', 'id_user', 'CASCADE', 'SET NULL');
        $this->forge->processIndexes('tbl_diagnosis');
    }

    public function down()
    {
        // The foreign key constraint is automatically named `tbl_diagnosis_id_user_foreign` by default
        $this->forge->dropForeignKey('tbl_diagnosis', 'tbl_diagnosis_id_user_foreign');
        $this->forge->dropColumn('tbl_diagnosis', 'id_user');
    }
}
