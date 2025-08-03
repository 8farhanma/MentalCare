<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblDiagnosis extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_diagnosis' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_penyakit' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'jk' => [
                'type' => 'VARCHAR',
                'constraint' => 25,
            ],
            'pekerjaan' => [
                'type' => 'VARCHAR',
                'constraint' => 25,
            ],
            'riwayat_kesehatan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                'default' => 'Tidak ada riwayat gangguan mental sebelumnya'
            ],
            'tgl_diagnosis' => [
                'type' => 'DATE',
            ],
            'cf_akhir' => [
                'type' => 'FLOAT',
            ],
            'presentase' => [
                'type' => 'FLOAT',
            ],
            'p_1' => [
                'type' => 'TEXT',
            ],
            'p_2' => [
                'type' => 'TEXT',
            ],
            'p_3' => [
                'type' => 'TEXT',
            ],
            'p_4' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_diagnosis', true);
        $this->forge->addForeignKey('id_penyakit', 'tbl_penyakit', 'id_penyakit');
        $this->forge->createTable('tbl_diagnosis');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_diagnosis');
    }
}
