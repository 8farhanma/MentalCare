<?php

namespace App\Controllers;

use App\Models\AturanModel;
use App\Models\GejalaModel;
use App\Models\PenyakitModel;
use App\Models\UserModel;
use App\Models\FaqModel;
use App\Models\DiagnosisModel;

class RecycleBinController extends BaseController
{
    public function __construct()
    {
        helper('date');
    }

    public function index()
    {
        $aturanModel = new AturanModel();
        $gejalaModel = new GejalaModel();
        $penyakitModel = new PenyakitModel();
        $userModel = new UserModel();
        $faqModel = new FaqModel();
        $diagnosisModel = new DiagnosisModel();

        // Ambil data yang di-soft delete dari setiap model
        $deletedAturan = $aturanModel->onlyDeleted()->findAll();
        $deletedLaporan = $diagnosisModel->onlyDeleted()
            ->select('tbl_diagnosis.*, COALESCE(tbl_diagnosis.nama, u.nama_lengkap) as nama_pasien, p.nama_penyakit')
            ->join('tbl_user u', 'u.id_user = tbl_diagnosis.id_user', 'left')
            ->join('tbl_penyakit p', 'p.id_penyakit = tbl_diagnosis.id_penyakit', 'left')
            ->findAll();
        $deletedGejala = $gejalaModel->onlyDeleted()->findAll();
        $deletedPenyakit = $penyakitModel->onlyDeleted()->findAll();
        $deletedUsers = $userModel->onlyDeleted()->findAll();
        $deletedFaq = $faqModel->onlyDeleted()->findAll();

        // Mengambil relasi untuk data aturan
        foreach ($deletedAturan as $key => $aturan) {
            $deletedAturan[$key]['penyakit'] = (new PenyakitModel())->withDeleted()->find($aturan['id_penyakit']);
            $deletedAturan[$key]['gejala'] = (new GejalaModel())->withDeleted()->find($aturan['id_gejala']);
        }

        $data = [
            'title' => 'Recycle Bin',
            'aturan' => $deletedAturan,
            'gejala' => $deletedGejala,
            'penyakit' => $deletedPenyakit,
            'users' => $deletedUsers,
            'faq' => $deletedFaq,
            'laporan' => $deletedLaporan,
        ];

        return view('admin/recycle_bin/index', $data);
    }

    public function restore($type, $id)
    {
        $model = $this->getModel($type);
        if ($model) {
            // Use the query builder for a direct update to avoid model validation issues
            $db = db_connect();
            $builder = $db->table($model->table);
            $builder->where($model->primaryKey, $id)->set('deleted_at', null)->update();

            return redirect()->to('admin/recycle_bin')->with('success', ucfirst($type) . ' berhasil dipulihkan.');
        }
        return redirect()->to('admin/recycle_bin')->with('error', 'Tipe data tidak valid.');
    }

    public function force_delete($type, $id)
    {
        $model = $this->getModel($type);
        if ($model) {
            $model->delete($id, true); // Purge the record
            return redirect()->to('admin/recycle_bin')->with('success', ucfirst($type) . ' berhasil dihapus permanen.');
        }
        return redirect()->to('admin/recycle_bin')->with('error', 'Tipe data tidak valid.');
    }

    public function restore_all($type)
    {
        $model = $this->getModel($type);
        if ($model) {
            $deletedItems = $model->onlyDeleted()->findAll();

            if (empty($deletedItems)) {
                return redirect()->to('admin/recycle_bin')->with('info', 'Tidak ada data ' . ucfirst($type) . ' untuk dipulihkan.');
            }

            $idsToRestore = array_column($deletedItems, $model->primaryKey);

            // Use the query builder for a direct update to avoid model validation issues
            $db = db_connect();
            $builder = $db->table($model->table);
            $builder->whereIn($model->primaryKey, $idsToRestore)->set('deleted_at', null)->update();

            return redirect()->to('admin/recycle_bin')->with('success', 'Semua ' . ucfirst($type) . ' berhasil dipulihkan.');
        }
        return redirect()->to('admin/recycle_bin')->with('error', 'Tipe data tidak valid.');
    }

    public function force_delete_all($type)
    {
        $model = $this->getModel($type);
        if ($model) {
            $model->purgeDeleted();
            return redirect()->to('/admin/recycle_bin')->with('success', 'Semua data ' . ucfirst($type) . ' berhasil dihapus permanen.');
        } else {
            return redirect()->to('/admin/recycle_bin')->with('error', 'Aksi tidak valid atau model tidak ditemukan.');
        }
    }

    private function getModel($type)
    {
        switch ($type) {
            case 'aturan':
                return new AturanModel();
            case 'gejala':
                return new GejalaModel();
            case 'penyakit':
                return new PenyakitModel();
            case 'user':
                return new UserModel();
            case 'faq':
                return new FaqModel();
            case 'laporan':
                return new DiagnosisModel();
            default:
                return null;
        }
    }
}
