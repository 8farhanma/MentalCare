<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class PurgeSoftDeletes extends BaseCommand
{
    protected $group       = 'Maintenance';
    protected $name        = 'maintenance:purge-deleted';
    protected $description = 'Hard delete records that have been soft deleted for more than a specified number of days (default 30).';
    protected $usage       = 'maintenance:purge-deleted [days] [--days number]';
    protected $arguments   = [
        'days' => 'Usia (hari) sebelum hard delete. Opsional, default 30. Bisa juga via --days=number',
    ];

    public function run(array $params)
    {
        // List all model classes that use soft deletes.
        $models = [
            \App\Models\UserModel::class,
            \App\Models\AturanModel::class,
            \App\Models\DiagnosisModel::class,
            \App\Models\FaqModel::class,
            \App\Models\GejalaModel::class,
            \App\Models\PenyakitModel::class,
            // Tambahkan model lain di sini jika diperlukan
        ];

        // Tentukan usia (hari) sebelum hard delete
        // Prioritas: argumen posisi > option CLI > default 30
        $ageInDays = isset($params[0]) ? (int) $params[0] : (int) (CLI::getOption('days') ?? 30);
        if ($ageInDays < 0) {
            CLI::error('Nilai days tidak valid. Harus >= 0');
            return;
        }
        $totalPurged = 0;

        foreach ($models as $modelClass) {
            if (!class_exists($modelClass)) {
                CLI::error("Model {$modelClass} tidak ditemukan, dilewati.");
                continue;
            }

            /** @var \CodeIgniter\Model $model */
            $model = new $modelClass();

            if (!property_exists($model, 'useSoftDeletes') || $model->useSoftDeletes !== true) {
                CLI::write("Model {$modelClass} tidak menggunakan soft deletes, dilewati.");
                continue;
            }

            // Hitung dahulu berapa baris yang akan di‐purge
            $countPurged = $model->builder()
                                 ->where('deleted_at IS NOT NULL')
                                 ->where('deleted_at <', date('Y-m-d H:i:s', strtotime("-{$ageInDays} days")))
                                 ->countAllResults(false);

            // Jalankan purge
            $model->purgeDeleted($ageInDays);

            $totalPurged += $countPurged;
            CLI::write("{$countPurged} baris dari {$modelClass} berhasil dihapus permanen.");
        }

        CLI::write("\nPurge selesai. Total baris dihapus permanen: {$totalPurged}");
    }
}
