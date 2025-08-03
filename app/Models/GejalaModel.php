<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Traits\SoftRestoreTrait;

class GejalaModel extends Model
{
    use SoftRestoreTrait;
    protected $table = 'tbl_gejala';
    protected $primaryKey = 'id_gejala';
    protected $allowedFields = ['kode_gejala', 'nama_gejala'];

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