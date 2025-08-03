<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GejalaModel;
use App\Models\CFUserModel;
use App\Models\DiagnosisModel;
use App\Models\PenyakitModel;
use App\Models\AturanModel;
use App\Models\DiagnosisGejalaModel;
use App\Models\UserActivityModel;
use Dompdf\Dompdf;

class MasterDiagnosisController extends BaseController
{
    public function cek_diagnosis()
    {
        $gejala = new GejalaModel();
        $cfUserModel = new CFUserModel();

        $data['result'] = $gejala->findAll();
        $data['listCFUser'] = $cfUserModel->findAll();
        $data['title'] = 'Cek Diagnosis';
        return view('diagnosis/index', $data);
    }
    
    public function hitung()
    {
        $aturanModel = new AturanModel();
        $diagnosisModel = new DiagnosisModel();
        $gejalaModel = new GejalaModel();
        $penyakitModel = new PenyakitModel();
        $cfUserModel = new CFUserModel();
        $diagnosisGejalaModel = new DiagnosisGejalaModel();

        $namaLengkap = $this->request->getVar('nama');
        $jk = $this->request->getVar('jk');
        $pekerjaan = $this->request->getVar('pekerjaan');
        $tglDiagnosis = $this->request->getVar('tgl_diagnosis');
        $listSelectedGejala = $this->request->getVar('selectedGejala');
        $listCF = $this->request->getVar('cf');
        $p_1 = $this->request->getVar('p_1');
        $p_3_value = $this->request->getVar('p_3');
        $p_2_radio = $this->request->getVar('p_2_radio');
        $p_2 = ($p_2_radio === 'Ya') ? $this->request->getVar('p_2_detail') : 'Tidak';

        $p_3_value = $this->request->getVar('p_3');
        $p_3 = ($p_3_value === 'lainnya') ? $this->request->getVar('p_3_lainnya') : $p_3_value;

        if (count($listSelectedGejala) < 2 || empty($listCF)) {
            return redirect()->to('user/diagnosis/wellness');
        }

        // Cek jika semua CF yang dipilih memiliki nilai 0
        $allCfAreZero = true;
        foreach ($listCF as $id_gejala => $id_cf_user) {
            $cfValue = $cfUserModel->find($id_cf_user);
            if ($cfValue && $cfValue['cf'] != 0) {
                $allCfAreZero = false;
                break;
            }
        }

        if ($allCfAreZero) {
            return redirect()->to('user/diagnosis/wellness');
        }

        // Debug input data
        log_message('debug', 'Selected Gejala: ' . print_r($listSelectedGejala, true));
        log_message('debug', 'List CF: ' . print_r($listCF, true));

        $mergedData = array();
        $listGejala = array(); 
        $mergedDataCf = array(); 

        foreach ($listSelectedGejala as $idGejala) {
            // Gunakan $idGejala sebagai kunci untuk mengakses array $listCF
            if (isset($listCF[$idGejala]) && !empty($listCF[$idGejala])) {
                $cfUserID = $listCF[$idGejala];
                $cfKepercayaan = $cfUserModel->where('id_cf_user', $cfUserID)->first();
                
                if ($cfKepercayaan) {
                    $mergedDataCf[] = [
                        'id_gejala' => $idGejala,
                        'tingkat_kepercayaan' => $cfKepercayaan['nama_nilai'],
                        'cf_user' => $cfKepercayaan['cf'],
                    ];
                }
            }
        }

        // Debug merged data
        log_message('debug', 'Merged Data CF: ' . print_r($mergedDataCf, true));

        $selectedGejalaCount = count($listSelectedGejala);
        $unselectedGejalaCount = $gejalaModel->countAllResults() - $selectedGejalaCount;

        $cf = array();
        $penyakitCodes = array();
        $penyakitNames = array();

        for ($i = 0; $i < count($mergedDataCf); $i++) {
            $val = $mergedDataCf[$i];
            $relation = $aturanModel->where('id_gejala', $val['id_gejala'])->findAll();
            
            // Debug relasi
            log_message('debug', 'Checking relation for gejala ' . $val['id_gejala'] . ': ' . print_r($relation, true));
            
            $gejala = $gejalaModel->where('id_gejala', $val['id_gejala'])->first();

            if ($relation != null && count($relation) > 0) {
                $listGejalaValue = [
                    'id_gejala' => $gejala['id_gejala'],
                    'kode_gejala' => $gejala['kode_gejala'],
                    'nama_gejala' => $gejala['nama_gejala'],
                    'tingkat_kepercayaan' => $val['tingkat_kepercayaan'],
                    'cf_user' => $val['cf_user'],
                    'nilai_cf' => 0,
                    'id_penyakit' => 0,
                    'kode_penyakit' => array(),
                    'nama_penyakit' => array()
                ];

                foreach ($relation as $r) {
                    $penyakit = $penyakitModel->find($r['id_penyakit']);
                    
                    // Debug penyakit
                    log_message('debug', 'Found penyakit for relation: ' . print_r($penyakit, true));
                    
                    if ($penyakit) {
                        $value = [
                            'id_gejala' => $gejala['id_gejala'],
                            'kode_gejala' => $gejala['kode_gejala'],
                            'nama_gejala' => $gejala['nama_gejala'],
                            'tingkat_kepercayaan' => $val['tingkat_kepercayaan'],
                            'cf_user' => $val['cf_user'],
                            'cf_pakar' => $r['cf'],
                            'nilai_cf' => $val['cf_user'] * $r['cf'],
                            'id_penyakit' => $r['id_penyakit']
                        ];

                        // probability calculation
                        $listGejalaValue['nilai_cf'] = $val['cf_user'] * $r['cf'];
                        $listGejalaValue['id_penyakit'] = $r['id_penyakit'];
                        $listGejalaValue['kode_penyakit'][] = $penyakit['kode_penyakit'];
                        $listGejalaValue['nama_penyakit'][] = $penyakit['nama_penyakit'];

                        array_push($cf, $value);
                        
                        // Debug: setelah menambahkan ke array cf
                        log_message('debug', 'Added to CF array: ' . print_r($value, true));
                    }
                }

                array_push($listGejala, $listGejalaValue);
            }
        }

        // Debug final cf array
        log_message('debug', 'Final CF Array: ' . print_r($cf, true));

        $cfCombine = 0;
        $groupByPenyakit = array();

        foreach ($cf as $pen) {
            $groupByPenyakit[$pen['id_penyakit']][] = $pen;
        }

        // Debug grouped data
        log_message('debug', 'Grouped By Penyakit: ' . print_r($groupByPenyakit, true));

        $new = array();

        if (!empty($cf)) {
            foreach ($groupByPenyakit as $idPenyakit => $depresi) {
                $cfCombine = 0;
                
                if (count($depresi) > 1) {
                    for ($j = 0; $j < count($depresi) - 1; $j++) {
                        if ($j === 0) {
                            $cfCombine = $depresi[$j]['nilai_cf'] + ($depresi[$j + 1]['nilai_cf'] * (1 - $depresi[$j]['nilai_cf']));
                        } else {
                            $cfCombine = $cfCombine + ($depresi[$j + 1]['nilai_cf'] * (1 - $cfCombine));
                        }
                    }
                } else {
                    $cfCombine = $depresi[0]['nilai_cf'];
                }
                
                $new[] = [
                    'id_penyakit' => $idPenyakit,
                    'nilai_cf' => $cfCombine
                ];
            }
        }

        log_message('debug', 'Isi array $new: ' . print_r($new, true));
        
        if (empty($new)) {
            log_message('error', 'Array hasil perhitungan CF kosong');
            return redirect()->to('user/diagnosis/error-page')->with('error', 'Tidak ada hasil perhitungan yang valid');
        }

        $maxCfValue = 0;
        $idPenyakitTerbesar = 0;
        
        foreach ($new as $item) {
            if ($item['nilai_cf'] > $maxCfValue) {
                $maxCfValue = $item['nilai_cf'];
                $idPenyakitTerbesar = $item['id_penyakit'];
            }
        }

        // Validasi hasil perhitungan
        if ($maxCfValue <= 0 || $idPenyakitTerbesar <= 0) {
            log_message('error', 'Tidak ada nilai CF yang valid. Max CF: ' . $maxCfValue . ', ID Penyakit: ' . $idPenyakitTerbesar);
            return redirect()->to('user/diagnosis/error-page')->with('error', 'Tidak ada hasil diagnosis yang valid');
        }

        log_message('debug', 'Max CF Value: ' . $maxCfValue);
        log_message('debug', 'ID Penyakit Terbesar: ' . $idPenyakitTerbesar);

        $penyakitData = $penyakitModel->find($idPenyakitTerbesar);
        
        log_message('debug', 'Penyakit Data: ' . print_r($penyakitData, true));

        if ($penyakitData === null) {
            log_message('error', 'Data penyakit tidak ditemukan untuk ID: ' . $idPenyakitTerbesar);
            return redirect()->to('user/diagnosis/error-page')->with('error', 'Data penyakit tidak ditemukan');
        }

        $kodePenyakit = $penyakitData['kode_penyakit'];
        $namaPenyakit = $penyakitData['nama_penyakit'];
        $deskripsi = $penyakitData['deskripsi_penyakit'];
        $solusi = $penyakitData['solusi_penyakit'];

        $diagnosisData = [
            'id_penyakit' => $idPenyakitTerbesar,
            'nama' => $namaLengkap,
            'jk' => $jk,
            'pekerjaan' => $pekerjaan,
            'tgl_diagnosis' => $tglDiagnosis,
            'cf_akhir' => $maxCfValue,
            'presentase' => number_format($maxCfValue * 100, 2),
            'p_1' => $p_1,
            'p_2' => $p_2,
            'p_3' => $p_3,
        ];

        $diagnosisModel->insert($diagnosisData);
        $diagnosisId = $diagnosisModel->getInsertID();

        // Log user activity if logged in
                if (session()->get('login_diagnosis')) {
            $activityModel = new UserActivityModel();
            $activityModel->insert([
                'id_user' => session()->get('user_id'),
                'activity_description' => 'Melakukan diagnosis dengan hasil: ' . $penyakitData['nama_penyakit']
            ]);
        }

        $diagnosisGejala = array();
        foreach ($cf as $val) {
            $cfUser = $cfUserModel->where('nama_nilai', $val['tingkat_kepercayaan'])->first();
            
            if ($cfUser) {
                $diagnosisGejala[] = [
                    'id_diagnosis' => $diagnosisId,
                    'id_gejala' => $val['id_gejala'],
                    'id_penyakit' => $val['id_penyakit'],
                    'id_cf_user' => $cfUser['id_cf_user'],
                    'cf_hasil' => $val['nilai_cf']
                ];
            }
        }

        if (!empty($diagnosisGejala)) {
            $diagnosisGejalaModel->insertBatch($diagnosisGejala);
        }

        $resultDiagnosis = [
            'nama' => $namaLengkap,
            'jk' => $jk,
            'pekerjaan' => $pekerjaan,
            'tgl_diagnosis' => $tglDiagnosis,
            'tingkat_kepercayaan' => $maxCfValue,
            'cf_akhir' => $maxCfValue,
            'gejala' => $listGejala,
            'deskripsi' => $deskripsi,
            'solusi_penyakit' => $solusi,
            'nama_penyakit' => $namaPenyakit,
            'kode_penyakit' => $kodePenyakit,
            'p_1' => $p_1,
            'p_2' => $p_2,
            'p_3' => $p_3,
            'presentase' => number_format($maxCfValue * 100, 2),
            'jumlah_gejala' => $selectedGejalaCount,
            'jumlah_gejala_tidak_terpilih' => $unselectedGejalaCount,
        ];

        $idPenyakitArray = array_column($diagnosisGejala, 'id_penyakit');
        $penyakit = $penyakitModel->whereIn('id_penyakit', $idPenyakitArray)->findAll();

        $idNamaPenyakitArray = [];
        $idKodePenyakitArray = [];

        foreach ($penyakit as $item) {
            $idNamaPenyakitArray[$item['id_penyakit']] = $item['nama_penyakit'];
            $idKodePenyakitArray[$item['id_penyakit']] = $item['kode_penyakit'];
        }

        $data['idPenyakitArray'] = array_map(function ($gejala) use ($idNamaPenyakitArray, $idKodePenyakitArray) {
            return [
                'id_penyakit' => $gejala['id_penyakit'],
                'nama_penyakit' => $idNamaPenyakitArray[$gejala['id_penyakit']],
                'kode_penyakit' => $idKodePenyakitArray[$gejala['id_penyakit']],
                'cf_hasil' => $gejala['cf_hasil'],
                'persentase' => number_format($gejala['cf_hasil'] * 100, 2) . '%',
            ];
        }, $diagnosisGejala);

        $data['idPenyakitArray'] = array_unique($data['idPenyakitArray'], SORT_REGULAR);
        $data['resultDiagnosis'] = $resultDiagnosis;
        $data['resultDiagnosis']['gejala'] = $listGejala;
        $data['penyakitCodes'] = $penyakitCodes;
        $data['penyakitNames'] = $penyakitNames;
        $data['cf'] = $cf;
        $data['title'] = 'Hasil Diagnosis';

        return view('diagnosis/hasil_diagnosis', $data);
    }

    public function wellness()
    {
        $data['title'] = 'Program Wellness & Preventif';
        return view('diagnosis/wellness', $data);
    }

    public function cetakDiagnosis()
    {
        $diagnosisModel = new DiagnosisModel();
        $diagnosisGejalaModel = new DiagnosisGejalaModel();

        $lastDiagnosis = $diagnosisModel->orderBy('id_diagnosis', 'DESC')->first();
        $pasienId = $lastDiagnosis['id_diagnosis'];
        
        $laporanDiagnosis = $diagnosisModel->select('tbl_diagnosis.*, tbl_penyakit.kode_penyakit, tbl_penyakit.nama_penyakit, tbl_penyakit.deskripsi_penyakit, tbl_penyakit.solusi_penyakit')
        ->join('tbl_penyakit', 'tbl_penyakit.id_penyakit = tbl_diagnosis.id_penyakit', 'left')
        ->where('tbl_diagnosis.id_diagnosis', $pasienId)
        ->findAll();

        $lastDiagnosisGejala = $diagnosisGejalaModel->orderBy('id', 'DESC')->first();

        $laporanGejala = $diagnosisGejalaModel->select('tbl_diagnosis_gejala.*, tbl_gejala.kode_gejala, tbl_gejala.nama_gejala, tbl_cf_user.nama_nilai, tbl_cf_user.cf, tbl_penyakit.kode_penyakit, tbl_penyakit.nama_penyakit')
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
        $filename = 'Laporan-Diagnosis_' . date('d-M-Y') . '.pdf';
        $response = service('response');
        $response->setContentType('application/pdf');
        $response->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"');
        $response->setBody($pdfContent);
        
        return $response;
    }

    // public function errorPage()
    // {
    //     $data['title'] = 'Error';
    //     return view('diagnosis/error', $data);
    // }
}