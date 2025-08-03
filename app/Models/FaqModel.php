<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Traits\SoftRestoreTrait;

class FaqModel extends Model
{
    use SoftRestoreTrait;
    protected $table = 'tbl_faq';
    protected $primaryKey = 'id_faq';
    protected $allowedFields = ['pertanyaan', 'jawaban'];

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