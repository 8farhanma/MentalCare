<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Traits\SoftRestoreTrait;

class AturanModel extends Model
{
    use SoftRestoreTrait;
    protected $table = 'tbl_aturan';
    protected $primaryKey = 'id_aturan';
    protected $allowedFields = ['id_penyakit', 'id_gejala', 'mb', 'md', 'cf'];

    // Soft Deletes
    protected $useSoftDeletes = true;
    protected $deletedField   = 'deleted_at';
    protected $useTimestamps  = false;

    public function penyakit()
    {
        return $this->belongsTo(PenyakitModel::class, 'id_penyakit', 'id_penyakit');
    }

    public function gejala()
    {
        return $this->belongsTo(GejalaModel::class, 'id_gejala', 'id_gejala');
    }

    public function getGejalaWithPenyakit($id_gejala)
    {
        // Build query
        $builder = $this->select('tbl_aturan.*, tbl_penyakit.kode_penyakit')
                    ->join('tbl_penyakit', 'tbl_penyakit.id_penyakit = tbl_aturan.id_penyakit')
                    ->where('tbl_aturan.id_gejala', $id_gejala);
        
        // Log the SQL query before execution
        log_message('debug', '==== QUERY DEBUG ====');
        log_message('debug', 'SQL Query: ' . $builder->getCompiledSelect(false));
        log_message('debug', 'Parameters: id_gejala = ' . $id_gejala);
        
        // Execute query
        $result = $builder->findAll();
        
        // Log the results
        log_message('debug', 'Query Results Count: ' . count($result));
        log_message('debug', 'Query Results: ' . print_r($result, true));
        log_message('debug', '===================');
        
        return $result;
    }

    public function restoreAll()
    {
        return $this->builder()
            ->where($this->deletedField . ' IS NOT NULL')
            ->set($this->deletedField, null)
            ->update();
    }
}