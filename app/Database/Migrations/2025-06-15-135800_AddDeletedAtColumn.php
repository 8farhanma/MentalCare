<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDeletedAtColumn extends Migration
{
    public function up()
    {
        $tables = [
            'tbl_user',
            'tbl_aturan',
            'tbl_diagnosis',
            'tbl_faq',
            'tbl_gejala',
            'tbl_penyakit',
        ];

        foreach ($tables as $table) {
            if (!$this->db->fieldExists('deleted_at', $table)) {
                $this->forge->addColumn($table, [
                    'deleted_at' => [
                        'type' => 'datetime',
                        'null' => true,
                    ],
                ]);
            }
        }
    }

    public function down()
    {
        $tables = [
            'tbl_user',
            'tbl_aturan',
            'tbl_diagnosis',
            'tbl_faq',
            'tbl_gejala',
            'tbl_penyakit',
        ];

        foreach ($tables as $table) {
            if ($this->db->fieldExists('deleted_at', $table)) {
                $this->forge->dropColumn($table, 'deleted_at');
            }
        }
    }
}
