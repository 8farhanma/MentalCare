<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AturanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['P01', 'G01', 0.8, 0, 0.8],
            ['P01', 'G05', 0.9, 0, 0.9],
            ['P01', 'G07', 0.8, 0, 0.8],
            ['P01', 'G10', 0.2, 0.4, -0.2],
            ['P02', 'G13', 0.6, 0, 0.6],
            ['P02', 'G14', 0.9, 0, 0.9],
            ['P02', 'G16', 0.8, 0, 0.8],
            ['P03', 'G01', 0.8, 0, 0.8],
            ['P03', 'G02', 0.8, 0, 0.8],
            ['P03', 'G05', 0.8, 0, 0.8],
            ['P03', 'G06', 0.9, 0, 0.9],
            ['P03', 'G07', 0.8, 0, 0.8],
            ['P03', 'G10', 0.8, 0, 0.8],
            ['P04', 'G09', 0.7, 0, 0.7],
            ['P04', 'G12', 0.9, 0, 0.9],
            ['P04', 'G13', 0.8, 0, 0.8],
            ['P04', 'G16', 0.6, 0, 0.6],
            ['P05', 'G01', 0.9, 0, 0.9],
            ['P05', 'G02', 0.7, 0, 0.7],
            ['P05', 'G03', 0.8, 0, 0.8],
            ['P05', 'G04', 0.9, 0, 0.9],
            ['P05', 'G05', 0.8, 0, 0.8],
            ['P05', 'G06', 0.8, 0, 0.8],
            ['P05', 'G07', 0.8, 0, 0.8],
            ['P05', 'G08', 1.0, 0, 1.0],
            ['P05', 'G10', 0.8, 0, 0.8],
            ['P06', 'G09', 0.8, 0, 0.8],
            ['P06', 'G11', 0.8, 0, 0.8],
            ['P06', 'G12', 0.8, 0, 0.8],
            ['P06', 'G13', 0.6, 0, 0.6],
            ['P06', 'G14', 0.6, 0, 0.6],
            ['P06', 'G15', 0.7, 0, 0.7],
            ['P06', 'G16', 0.6, 0, 0.6],
            ['P06', 'G17', 0.9, 0, 0.9],
        ];

        // Get the actual IDs from the reference tables
        foreach ($data as $row) {
            $gejala = $this->db->table('tbl_gejala')
                ->where('kode_gejala', $row[1])
                ->get()
                ->getRow();

            $penyakit = $this->db->table('tbl_penyakit')
                ->where('kode_penyakit', $row[0])
                ->get()
                ->getRow();

            if ($gejala && $penyakit) {
                $this->db->table('tbl_aturan')->insert([
                    'id_gejala' => $gejala->id_gejala,
                    'id_penyakit' => $penyakit->id_penyakit,
                    'mb' => $row[2],
                    'md' => $row[3],
                    'cf' => $row[4],
                ]);
            }
        }
    }
}
