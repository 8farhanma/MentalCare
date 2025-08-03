<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GejalaModel;
use App\Models\CFUserModel;
use App\Models\DiagnosisModel;
use App\Models\PenyakitModel;
use App\Models\AturanModel;
use App\Models\DiagnosisGejalaModel;
use App\Models\UserModel;

class DiagnosisController extends BaseController
{
    protected $diagnosisModel;
    protected $gejalaModel;
    protected $penyakitModel;
    protected $cfUserModel;
    protected $aturanModel;
    protected $diagnosisGejalaModel;
    protected $userModel;

    public function __construct()
    {
        $this->diagnosisModel = new DiagnosisModel();
        $this->gejalaModel = new GejalaModel();
        $this->penyakitModel = new PenyakitModel();
        $this->cfUserModel = new CFUserModel();
        $this->aturanModel = new AturanModel();
        $this->diagnosisGejalaModel = new DiagnosisGejalaModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('login-user')->with('error', 'Silakan login terlebih dahulu');
        }

        // Get fresh user data
        $userData = $this->userModel->find(session()->get('user_id'));
        
        if (!$userData) {
            session()->destroy();
            return redirect()->to('login-user')->with('error', 'Sesi anda telah berakhir, silakan login kembali');
        }
        
        // Update session with latest user data
        $sessionData = [
            'user_id' => $userData['id_user'],
            'email' => $userData['email'],
            'nama_lengkap' => $userData['nama_lengkap'],
            'jenis_kelamin' => $userData['jenis_kelamin'],
            'pekerjaan' => $userData['pekerjaan'],
            'role' => $userData['role'],
            'logged_in' => true
        ];
        session()->set($sessionData);

        $data = [
            'title' => 'Diagnosis Tingkat Depresi',
            'gejala' => $this->gejalaModel->findAll(),
            'listCFUser' => $this->cfUserModel->findAll(),
            'user' => $userData
        ];
        return view('diagnosis/index', $data);
    }

    public function hitung()
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('login-user')->with('error', 'Silakan login terlebih dahulu');
        }

        // Get fresh user data
        $userData = $this->userModel->find(session()->get('user_id'));
        
        if (!$userData) {
            session()->destroy();
            return redirect()->to('login-user')->with('error', 'Sesi anda telah berakhir, silakan login kembali');
        }

        // Update session with latest user data
        $sessionData = [
            'user_id' => $userData['id_user'],
            'email' => $userData['email'],
            'nama_lengkap' => $userData['nama_lengkap'],
            'jenis_kelamin' => $userData['jenis_kelamin'],
            'pekerjaan' => $userData['pekerjaan'],
            'role' => $userData['role'],
            'logged_in' => true
        ];
        session()->set($sessionData);

        // Get user input
        $selectedGejala = $this->request->getPost('selectedGejala');
        $cfValues = $this->request->getPost('cf');
        $p_4 = $this->request->getPost('p_4') ?? null;
        
        if (empty($selectedGejala) || empty($cfValues)) {
            return redirect()->back()->with('error', 'Mohon pilih gejala dan tingkat keyakinan terlebih dahulu');
        }

        // Save diagnosis record
        $diagnosisData = [
            'id_user'       => session()->get('user_id'),
            'nama'          => $userData['nama_lengkap'],
            'jk'            => $userData['jenis_kelamin'],
            'pekerjaan'     => $userData['pekerjaan'],
            'tgl_diagnosis' => date('Y-m-d'),
            'p_4'           => $p_4
        ];

        echo 'Final data to be inserted: '; dd($diagnosisData);
        $diagnosisId = $this->diagnosisModel->insert($diagnosisData);

        if (!$diagnosisId) {
            return redirect()->back()->with('error', 'Gagal menyimpan data diagnosis awal. Silakan coba lagi.');
        }

        // Calculate CF for each symptom
        $cfCombine = 0;
        foreach ($selectedGejala as $gejalaId => $cfUser) {
            $aturan = $this->aturanModel->where('id_gejala', $gejalaId)->first();
            
            if ($aturan) {
                // Find the corresponding id_cf_user for the given CF value ($cfUser)
                $cfRow = $this->cfUserModel->where('cf', $cfUser)->first();
                $id_cf_user = $cfRow ? $cfRow['id_cf_user'] : null;

                $cfPakar = $aturan['cf_pakar'];
                $cfHitung = (float)$cfUser * (float)$cfPakar;

                // Save to tbl_diagnosis_gejala
                $diagGejalaData = [
                    'id_diagnosis' => $diagnosisId,
                    'id_gejala'    => $gejalaId,
                    'id_penyakit'  => $aturan['id_penyakit'],
                    'id_cf_user'   => $id_cf_user,
                    'cf_hasil'     => $cfHitung
                ];
                $this->diagnosisGejalaModel->insert($diagGejalaData);

                // Combine CF values (original logic)
                if ($cfCombine == 0) {
                    $cfCombine = $cfHitung;
                } else {
                    $cfCombine = $cfCombine + ($cfHitung * (1 - $cfCombine));
                }
            }
        }

        // Get diagnosis result based on CF value
        $resultPenyakit = $this->penyakitModel->getResultByValue($cfCombine);

        if ($resultPenyakit) {
            // Update diagnosis with result
            $this->diagnosisModel->update($diagnosisId, [
                'id_penyakit' => $resultPenyakit['id_penyakit'],
                'cf_akhir' => $cfCombine
            ]);

            // Get selected gejala details with related penyakit
            $selectedGejalaDetails = [];
            $penyakitCodes = [];
            $cfDetails = [];
            
            foreach ($selectedGejala as $gejalaId => $cfUser) {
                $gejalaData = $this->gejalaModel->find($gejalaId);
                $aturanList = $this->aturanModel->getGejalaWithPenyakit($gejalaId);
                
                if ($gejalaData && $aturanList) {
                    // Get unique kode_penyakit for this gejala
                    $relatedPenyakitCodes = array_unique(array_column($aturanList, 'kode_penyakit'));
                    
                    // Debug logs
                    log_message('debug', '----------------------------------------');
                    log_message('debug', 'Processing Gejala ID: ' . $gejalaId);
                    log_message('debug', 'Related Penyakit Codes: ' . print_r($relatedPenyakitCodes, true));
                    
                    // Add gejala details with explicit kode_penyakit array
                    $selectedGejalaDetails[] = [
                        'id_gejala' => $gejalaId,
                        'kode_gejala' => $gejalaData['kode_gejala'],
                        'nama_gejala' => $gejalaData['nama_gejala'],
                        'tingkat_kepercayaan' => $this->cfUserModel->getKepercayaanText($cfUser),
                        'cf_user' => $cfUser,
                        'kode_penyakit' => $relatedPenyakitCodes
                    ];
                    
                    // Ensure we're adding to penyakitCodes array
                    if (!empty($relatedPenyakitCodes)) {
                        $penyakitCodes = array_values(array_unique(array_merge($penyakitCodes, $relatedPenyakitCodes)));
                    }
                    
                    // Prepare CF details for each aturan
                    foreach ($aturanList as $aturan) {
                        $cfDetails[] = [
                            'id_gejala' => $gejalaId,
                            'cf' => $aturan['cf'],
                            'cf_user' => $cfUser,
                            'nilai_cf' => $cfUser * $aturan['cf']
                        ];
                    }
                }
            }

            // Debug log final arrays
            log_message('debug', 'Final PenyakitCodes: ' . print_r(array_unique($penyakitCodes), true));
            log_message('debug', 'Final GejalaDetails: ' . print_r($selectedGejalaDetails, true));

            // Ensure penyakitCodes is unique and not empty
            $penyakitCodes = array_values(array_unique(array_filter($penyakitCodes)));

            // Debug the final data structure before sending to view
            log_message('debug', '==== FINAL DATA FOR VIEW ====');
            log_message('debug', 'Selected Gejala Details: ' . print_r($selectedGejalaDetails, true));
            log_message('debug', 'Penyakit Codes: ' . print_r($penyakitCodes, true));
            log_message('debug', '==========================');

            $penyakitData = $this->penyakitModel->find($resultPenyakit['id_penyakit']);
            $maxCFValue = $cfCombine;

            $data = [
                'title' => 'Hasil Diagnosis',
                'resultDiagnosis' => [
                    'gejala' => $selectedGejalaDetails,
                    'penyakitCodes' => array_values($penyakitCodes),
                    'cf' => $cfDetails
                ],
                'hasilDiagnosis' => $penyakitData,
                'persentase' => $maxCFValue * 100,
                'cfAkhir' => $maxCFValue
            ];

            // Debug final data structure
            log_message('debug', 'Final View Data: ' . print_r($data, true));

            return view('diagnosis/hasil_diagnosis', $data);
        }

        return redirect()->back()->with('error', 'Maaf, tidak dapat menentukan diagnosis. Silakan coba lagi.');
    }

    public function riwayat()
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('login-user')->with('error', 'Silakan login terlebih dahulu');
        }

        // Get fresh user data
        $userData = $this->userModel->find(session()->get('user_id'));
        
        if (!$userData) {
            session()->destroy();
            return redirect()->to('login-user')->with('error', 'Sesi anda telah berakhir, silakan login kembali');
        }
        
        // Update session with latest user data
        $sessionData = [
            'user_id' => $userData['id_user'],
            'email' => $userData['email'],
            'nama_lengkap' => $userData['nama_lengkap'],
            'jenis_kelamin' => $userData['jenis_kelamin'],
            'pekerjaan' => $userData['pekerjaan'],
            'role' => $userData['role'],
            'logged_in' => true
        ];
        session()->set($sessionData);

        $data = [
            'title' => 'Riwayat Diagnosis',
            'diagnosis' => $this->diagnosisModel->where('user_id', session()->get('user_id'))->findAll()
        ];
        return view('diagnosis/riwayat', $data);
    }
}
