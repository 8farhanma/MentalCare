<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Traits\SoftRestoreTrait;

class DiagnosisModel extends Model
{
    use SoftRestoreTrait;
    protected $DBGroup          = 'default';
    protected $table            = 'tbl_diagnosis';

    protected $primaryKey       = 'id_diagnosis';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_penyakit',
        'nama',
        'jk',
        'pekerjaan',
        'tgl_diagnosis',
        'cf_akhir',
        'presentase',
        'p_1',
        'p_2',
        'p_3'
    ];

    public function getLaporan()
    {
        return $this->select('tbl_diagnosis.*, tbl_penyakit.nama_penyakit, tbl_penyakit.nama_penyakit as hasil_diagnosis')
            ->join('tbl_penyakit', 'tbl_penyakit.id_penyakit = tbl_diagnosis.id_penyakit', 'left')
            ->select('tbl_diagnosis.nama as nama_lengkap, tbl_diagnosis.tgl_diagnosis as tanggal_diagnosis')
            ->findAll();
    }

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function restoreAll()
    {
        return $this->builder()
            ->where($this->deletedField . ' IS NOT NULL')
            ->set($this->deletedField, null)
            ->update();
    }
}