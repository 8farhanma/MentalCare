<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Traits\SoftRestoreTrait;

class PenyakitModel extends Model
{
    use SoftRestoreTrait;
    protected $table = 'tbl_penyakit';
    protected $primaryKey = 'id_penyakit';
    protected $allowedFields = ['kode_penyakit', 'nama_penyakit', 'deskripsi_penyakit', 'solusi_penyakit'];

    // Soft Deletes
    protected $useSoftDeletes = true;
    protected $deletedField   = 'deleted_at';
    protected $useTimestamps  = false;

    public function restoreAll()
    {
        return $this->builder()
            ->where($this->deletedField . ' IS NOT NULL')
            ->set($this->deletedField, null)
            ->update();
    }
}