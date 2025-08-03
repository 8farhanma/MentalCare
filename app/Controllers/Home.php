<?php

namespace App\Controllers;

use App\Models\FaqModel;
use App\Models\DiagnosisModel;

class Home extends BaseController
{
    public function index()
    {
        $faqModel = new FaqModel();
        $data['faq'] = $faqModel->asObject()->findAll();

        $diagnosisModel = new DiagnosisModel();
        $data['laporan'] = $diagnosisModel->findAll();
        $data['title'] = 'Homepage';

        $session = session();
        
        if ($session->get('logged_in') || $session->get('login_diagnosis')) {
            return redirect()->back()->with('error', 'Anda harus logout terlebih dahulu');
        }

        return view('landing', $data);
    }
}