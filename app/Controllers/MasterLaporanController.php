<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DiagnosisModel;
use App\Models\DiagnosisGejalaModel;
use App\Models\PenyakitModel;
use App\Models\GejalaModel;
use App\Models\CFUserModel;
use App\Models\AturanModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;

class MasterLaporanController extends BaseController
{
    public function index()
    {
        $diagnosisModel = new DiagnosisModel();
        $laporan = $diagnosisModel->getLaporan();
        $data = [
            'title' => 'Data Laporan',
            'laporan' => $laporan 
        ];

        return view('admin/master_laporan/index', $data);
    }

    public function lihat($idDiagnosis)
    {
        $diagnosisModel = new DiagnosisModel();
        $diagnosisGejalaModel = new DiagnosisGejalaModel();
        $penyakitModel = new PenyakitModel();
        $gejalaModel = new GejalaModel();  
        $CFUserModel = new CFUserModel(); 
        $aturanModel = new AturanModel();

        $diagnosis = $diagnosisModel->find($idDiagnosis);

        $diagnosisGejala = $diagnosisGejalaModel
            ->select('tbl_diagnosis_gejala.*, g.kode_gejala, g.nama_gejala, p.kode_penyakit, p.nama_penyakit, cf.nama_nilai, cf.cf, a.cf as cf_pakar, tbl_diagnosis_gejala.cf_hasil')
            ->join('tbl_gejala as g', 'g.id_gejala = tbl_diagnosis_gejala.id_gejala', 'left')
            ->join('tbl_penyakit as p', 'p.id_penyakit = tbl_diagnosis_gejala.id_penyakit', 'left')
            ->join('tbl_cf_user as cf', 'cf.id_cf_user = tbl_diagnosis_gejala.id_cf_user', 'left')
            ->join('tbl_aturan as a', 'a.id_gejala = tbl_diagnosis_gejala.id_gejala AND a.id_penyakit = tbl_diagnosis_gejala.id_penyakit', 'left')
            ->where('tbl_diagnosis_gejala.id_diagnosis', $idDiagnosis)
            ->findAll();

        $penyakit = $penyakitModel->find($diagnosis['id_penyakit']);

        return view('admin/master_laporan/view', [
            'diagnosis' => $diagnosis,
            'diagnosisGejala' => $diagnosisGejala,
            'penyakit' => $penyakit,
            'title' => 'Laporan'
        ]);
    }

    public function delete($id_diagnosis)
    {
        $diagnosisModel = new DiagnosisModel();
        // Soft delete hanya pada tabel diagnosis
        $diagnosisModel->delete($id_diagnosis);

        return redirect()->to('/admin/master_laporan')->with('success', 'Data laporan berhasil dipindahkan ke Recycle Bin.');
    }



    public function softDeleteAll()
    {
        $diagnosisModel = new DiagnosisModel();
        $diagnosisGejalaModel = new DiagnosisGejalaModel();

        // Ambil semua data diagnosis yang belum dihapus
        $diagnoses = $diagnosisModel->where('deleted_at', null)->findAll();

        if (empty($diagnoses)) {
            return redirect()->to('admin/master_laporan')->with('info', 'Tidak ada data laporan yang dapat dipindahkan ke Recycle Bin.');
        }

        // Hapus data diagnosis_gejala terlebih dahulu untuk setiap diagnosis
        foreach ($diagnoses as $diagnosis) {
            $diagnosisGejalaModel->where('id_diagnosis', $diagnosis['id_diagnosis'])->delete();
        }

        // Soft delete semua diagnosis yang belum dihapus
        $diagnosisModel->where('deleted_at', null)->delete();

        return redirect()->to('admin/master_laporan')->with('success', 'Semua data laporan berhasil dipindahkan ke Recycle Bin.');
    }

    public function cetakExcel()
    {
        $diagnosisModel = new DiagnosisModel();
        // $penyakitModel = new PenyakitModel();

        $laporan = $diagnosisModel->select('tbl_diagnosis.*, tbl_penyakit.nama_penyakit')
        ->join('tbl_penyakit', 'tbl_penyakit.id_penyakit = tbl_diagnosis.id_penyakit', 'left')
        ->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Laporan Data Diagnosis');
        $sheet->setCellValue('A2', 'Tanggal Cetak: ' . date('d-m-Y'));
        $sheet->setCellValue('A3', '');

        $sheet->setCellValue('A4', 'No');
        $sheet->setCellValue('B4', 'Nama');
        $sheet->setCellValue('C4', 'Usia');
        $sheet->setCellValue('D4', 'Tanggal');
        $sheet->setCellValue('E4', 'Penyakit');
        $sheet->setCellValue('F4', 'CF Akhir');
        $sheet->setCellValue('G4', 'Presentase');

        $row = 5;
        foreach ($laporan as $key => $data) {
            $sheet->setCellValue('A' . $row, $key + 1);
            $sheet->setCellValue('B' . $row, $data['nama']);
            $sheet->setCellValue('C' . $row, $data['p_1']);
            $sheet->setCellValue('D' . $row, $data['tgl_diagnosis']);
            $sheet->setCellValue('E' . $row, $data['nama_penyakit']);
            $sheet->setCellValue('F' . $row, $data['cf_akhir']);
            $sheet->setCellValue('G' . $row, $data['presentase'] . '%');
            $row++;
        }

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);

        $filename = 'Laporan-Diagnosis_' . date('d-m-Y') . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $filePath = WRITEPATH . 'uploads/' . $filename;
        $writer->save($filePath);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);

        exit;
    }

    public function cetakPdf()
    {
        $diagnosisModel = new DiagnosisModel();

        $laporan = $diagnosisModel->select('tbl_diagnosis.*, tbl_penyakit.nama_penyakit')
        ->join('tbl_penyakit', 'tbl_penyakit.id_penyakit = tbl_diagnosis.id_penyakit', 'left')
        ->findAll();

        $view = view('admin/master_laporan/laporan_pdf', ['laporan' => $laporan]);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($view);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $pdfContent = $dompdf->output();
        $filename = 'Laporan-Diagnosis_' . date('d-m-Y') . '.pdf';
        $response = service('response');
        $response->setContentType('application/pdf');
        $response->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"');
        $response->setBody($pdfContent);

        return $response;
    }


    public function cetakLangsung()
    {
        $diagnosisModel = new DiagnosisModel();

        $laporan = $diagnosisModel->select('tbl_diagnosis.*, tbl_penyakit.nama_penyakit')
        ->join('tbl_penyakit', 'tbl_penyakit.id_penyakit = tbl_diagnosis.id_penyakit', 'left')
        ->findAll();

        $data = [
            'laporan' => $laporan,
            'title' => 'Cetak Laporan Diagnosis'
        ];

        $view = view('admin/master_laporan/cetak_laporan', $data);
        $response = service('response');
        $response->setContentType('text/html');
        $response->setBody($view);

        return $response;
    }

    public function unduhDiagnosis($id_diagnosis)
    {
        $diagnosisModel = new DiagnosisModel();
        $diagnosisGejalaModel = new DiagnosisGejalaModel();

        $lastDiagnosis = $diagnosisModel->orderBy('id_diagnosis', 'DESC')->first();
        $pasienId = $id_diagnosis;
        $laporanDiagnosis = $diagnosisModel->select('tbl_diagnosis.*, tbl_penyakit.kode_penyakit, tbl_penyakit.nama_penyakit, tbl_penyakit.deskripsi_penyakit, tbl_penyakit.solusi_penyakit')
        ->join('tbl_penyakit', 'tbl_penyakit.id_penyakit = tbl_diagnosis.id_penyakit', 'left')
        ->where('tbl_diagnosis.id_diagnosis', $pasienId)
        ->findAll();

        $lastDiagnosisGejala = $diagnosisGejalaModel->orderBy('id', 'DESC')->first();

        $laporanGejala = $diagnosisGejalaModel->select('tbl_diagnosis_gejala.*, tbl_gejala.kode_gejala, tbl_gejala.nama_gejala, tbl_cf_user.nama_nilai, tbl_cf_user.cf, tbl_penyakit.kode_penyakit, tbl_penyakit.nama_penyakit,')
        ->join('tbl_gejala', 'tbl_gejala.id_gejala = tbl_diagnosis_gejala.id_gejala', 'left')
        ->join('tbl_penyakit', 'tbl_penyakit.id_penyakit = tbl_diagnosis_gejala.id_penyakit', 'left')
        ->join('tbl_cf_user', 'tbl_cf_user.id_cf_user = tbl_diagnosis_gejala.id_cf_user', 'left')
        ->join('tbl_diagnosis', 'tbl_diagnosis.id_diagnosis = tbl_diagnosis_gejala.id_diagnosis', 'left')
        ->where('tbl_diagnosis.id_diagnosis', $pasienId)
        ->findAll();

        $view = view('diagnosis/cetak_diagnosis', ['laporanDiagnosis' => $laporanDiagnosis, 'laporanGejala' => $laporanGejala]);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($view);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $pdfContent = $dompdf->output();
        $filename = 'Laporan-Diagnosis_' . date('d-m-Y') . '.pdf';
        $response = service('response');
        $response->setContentType('application/pdf');
        $response->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"');
        $response->setBody($pdfContent);

        return $response;
    }

    public function truncateData()
    {
        $db = \Config\Database::connect();
        $db->transStart();
        
        try {
            // Get all diagnosis IDs that haven't been soft deleted yet
            $diagnosisModel = new DiagnosisModel();
            $diagnosisIds = $diagnosisModel->select('id_diagnosis')
                                         ->where('deleted_at', null)
                                         ->findAll();
            
            if (!empty($diagnosisIds)) {
                // Soft delete all diagnosis records
                foreach ($diagnosisIds as $diagnosis) {
                    $diagnosisModel->delete($diagnosis['id_diagnosis']);
                }
                
                $message = 'Semua data laporan berhasil dipindahkan ke Recycle Bin.';
            } else {
                $message = 'Tidak ada data laporan yang bisa dihapus.';
            }
            
            $db->transComplete();
            
            if ($db->transStatus() === FALSE) {
                $db->transRollback();
                return redirect()->to(base_url('admin/master_laporan'))
                               ->with('error', 'Gagal memindahkan data ke Recycle Bin.');
            }
            
            session()->setFlashdata('success', $message);
            return redirect()->to(base_url('admin/master_laporan'));
            
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', $e->getMessage());
            return redirect()->to(base_url('admin/master_laporan'))
                           ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}