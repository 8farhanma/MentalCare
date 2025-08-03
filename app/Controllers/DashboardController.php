<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GejalaModel;
use App\Models\PenyakitModel;
use App\Models\AturanModel;
use App\Models\FaqModel;
use App\Models\DiagnosisModel;
use App\Models\UserModel;
use App\Models\OtpModel;
use App\Models\ResetPasswordModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $model = new GejalaModel();
        $gejala = $model->findAll();

        $model = new PenyakitModel();
        $penyakit = $model->findAll();

        $model = new AturanModel();
        $aturan = $model->findAll();

        $model = new FaqModel();
        $faq = $model->findAll();

        $model = new DiagnosisModel();
        $diagnosis = $model->findAll();

        $model = new UserModel();
        $admin = $model->findAll();

        $model = new UserModel();
        $user = $model->findAll();

        $model = new OtpModel();
        $otp = $model->findAll();

        $model = new ResetPasswordModel();
        $token = $model->findAll();

        $data = [
            'gejala' => $gejala,
            'penyakit' => $penyakit,
            'aturan' => $aturan,
            'faq' => $faq,
            'diagnosis' => $diagnosis,
            'user' => $user,
            'admin' => $admin,
            'otp' => $otp,
            'token' => $token,
            'title' => 'Dashboard'
        ];

        return view('admin/index', $data);
    }
}