<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblDiagnosisGejala extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_diagnosis' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'id_gejala' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'id_penyakit' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'id_cf_user' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'cf_hasil' => [
                'type' => 'FLOAT',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_diagnosis', 'tbl_diagnosis', 'id_diagnosis', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_gejala', 'tbl_gejala', 'id_gejala', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_penyakit', 'tbl_penyakit', 'id_penyakit', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_cf_user', 'tbl_cf_user', 'id_cf_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tbl_diagnosis_gejala');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_diagnosis_gejala');
    }
}
