<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------

// MentalBot Chatbot Routes */
$routes->get('/mentalbot', 'MentalBot::index');
$routes->post('/mentalbot/ask', 'MentalBot::ask');

 

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

// Login Admin
$routes->get('AdministratorSign-In', 'Auth::showLogin');
$routes->post('/login', 'Auth::login');
$routes->get('admin/enable-2fa', 'TwoFAController::enable');
$routes->post('admin/enable-2fa', 'TwoFAController::enableVerify');
$routes->get('admin/verify-2fa', 'TwoFAController::verify');
$routes->post('admin/verify-2fa', 'TwoFAController::verifyProcess');
$routes->post('admin/disable-2fa', 'TwoFAController::disable');

// Flexible
$routes->get('/logout', 'Auth::logout');
$routes->get('logoutExpertSystem', 'Auth::logoutExpertSystem');

// $routes->get('login-user', 'Auth::showLoginUser');
// $routes->post('/login-user', 'Auth::loginUser');
// $routes->get('register', 'Auth::register');
// $routes->post('register', 'Auth::register');

// Login User
$routes->get('login-user', 'Auth::showLoginUser');
$routes->post('login-user', 'Auth::loginUser');
$routes->get('login-google', 'Auth::loginGoogle');
$routes->get('login-google/callback', 'Auth::googleCallback');
$routes->get('register', 'RegisterController::register');
$routes->post('register', 'RegisterController::register');
$routes->get('verify-otp', 'RegisterController::verifyOTP');
$routes->post('verify-otp', 'RegisterController::verifyOTP');
$routes->post('resend-otp', 'RegisterController::resendOTP');

// RESET PASSWORD
$routes->get('forgot-password', 'ResetPasswordController::forgotPassword');
$routes->post('forgot-password', 'ResetPasswordController::processForgotPassword');
$routes->get('reset-password/(:any)', 'ResetPasswordController::showResetForm/$1', ['as' => 'password.reset']);
$routes->post('reset-password', 'ResetPasswordController::reset', ['as' => 'password.update']);


$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'DashboardController::index');

    // Routes Gejala
    $routes->get('master_gejala', 'MasterGejalaController::index');
    $routes->get('master_gejala/new', 'MasterGejalaController::new');
    $routes->post('master_gejala/simpan', 'MasterGejalaController::simpan');
    $routes->get('master_gejala/edit/(:num)', 'MasterGejalaController::edit/$1');
    $routes->post('master_gejala/update/(:num)', 'MasterGejalaController::update/$1');
    $routes->delete('master_gejala/delete/(:num)', 'MasterGejalaController::delete/$1');

    // Routes Penyakit
    $routes->get('master_penyakit', 'MasterPenyakitController::index');
    $routes->get('master_penyakit/new', 'MasterPenyakitController::new');
    $routes->post('master_penyakit/simpan', 'MasterPenyakitController::simpan');
    $routes->get('master_penyakit/edit/(:num)', 'MasterPenyakitController::edit/$1');
    $routes->post('master_penyakit/update/(:num)', 'MasterPenyakitController::update/$1');
    $routes->match(['delete'], 'master_penyakit/(:num)', 'MasterPenyakitController::delete/$1');

    //Routes Aturan
    $routes->get('master_aturan', 'MasterAturanController::index');
    $routes->get('master_aturan/new', 'MasterAturanController::new');
    $routes->post('master_aturan/simpan', 'MasterAturanController::simpan');
    $routes->get('master_aturan/edit/(:num)', 'MasterAturanController::edit/$1');
    $routes->post('master_aturan/update/(:num)', 'MasterAturanController::update/$1');
    $routes->delete('master_aturan/delete/(:num)', 'MasterAturanController::delete/$1');

    // Routes Faq
    $routes->get('master_faq', 'MasterFaqController::index');
    $routes->get('master_faq/new', 'MasterFaqController::new');
    $routes->post('master_faq/simpan', 'MasterFaqController::simpan');
    $routes->get('master_faq/edit/(:num)', 'MasterFaqController::edit/$1');
    $routes->post('master_faq/update/(:num)', 'MasterFaqController::update/$1');
    $routes->post('master_faq/delete/(:num)', 'MasterFaqController::delete/$1');


    // Routes Laporan
    $routes->get('master_laporan', 'MasterLaporanController::index');
    $routes->get('master_laporan/lihat/(:num)', 'MasterLaporanController::lihat/$1');
    $routes->get('master_laporan/cetakExcel', 'MasterLaporanController::cetakExcel');
    $routes->get('master_laporan/cetakPdf', 'MasterLaporanController::cetakPdf');
    $routes->get('master_laporan/cetakLangsung', 'MasterLaporanController::cetakLangsung');
    $routes->post('master_laporan/softDeleteAll', 'MasterLaporanController::softDeleteAll');
    $routes->post('master_laporan/delete/(:num)', 'MasterLaporanController::delete/$1');


    // Data Importer
    $routes->get('importer', 'DataImporter::index');
    $routes->post('importer/upload', 'DataImporter::upload');
    $routes->get('master_laporan/unduhDiagnosis/(:any)', 'MasterLaporanController::unduhDiagnosis/$1');

    // Routes Admin & User
    $routes->get('master_admin', 'MasterUserController::index');
    $routes->match(['delete'], 'master_admin/(:num)', 'MasterUserController::delete/$1');
    $routes->get('master_admin/truncateData', 'MasterUserController::truncateData');
    $routes->get('master_user', 'MasterUserController::indexUser');
    $routes->post('master_user/truncate', 'MasterUserController::truncateDataUser');
    $routes->post('master_user/hapus/(:num)', 'MasterUserController::hapus/$1');
    $routes->get('master_user/activity/(:num)', 'MasterUserController::activity/$1');

    // Routes untuk Recycle Bin Terpusat
    $routes->get('recycle_bin', 'RecycleBinController::index');
    $routes->post('recycle_bin/restore/(:any)/(:num)', 'RecycleBinController::restore/$1/$2');
    $routes->post('recycle_bin/force_delete/(:any)/(:num)', 'RecycleBinController::force_delete/$1/$2');
    $routes->post('recycle_bin/restore_all/(:any)', 'RecycleBinController::restore_all/$1');
    $routes->post('recycle_bin/force_delete_all/(:any)', 'RecycleBinController::force_delete_all/$1');
    $routes->delete('recycle_bin/force_delete/(:any)/(:num)', 'RecycleBinController::force_delete/$1/$2');

    // OTP & Token
    $routes->get('master_otp', 'OTPController::index');
    $routes->match(['delete'], 'master_otp/(:num)', 'OTPController::delete/$1');
    $routes->get('master_otp/truncateData', 'OTPController::truncateData');
    $routes->get('master_token', 'OTPController::indexToken');
    $routes->match(['delete'], 'master_token/(:num)', 'OTPController::hapus/$1');
    $routes->get('master_token/truncateDataToken', 'OTPController::truncateDataToken');

});

$routes->group('user', ['filter' => 'auth'], function ($routes) {

    // Routes Diagnosis
    $routes->get('cek_diagnosis', 'MasterDiagnosisController::cek_diagnosis');
    $routes->post('hasil_diagnosis', 'MasterDiagnosisController::hitung');
    $routes->get('diagnosis/cetak_diagnosis', 'MasterDiagnosisController::cetakDiagnosis');
    $routes->get('diagnosis/wellness', 'MasterDiagnosisController::wellness');
    $routes->get('diagnosis/error', 'MasterDiagnosisController::errorPage');
    $routes->get('error-page', 'MasterDiagnosisController::errorPage');  
    // $routes->get('diagnosis/hasil/(:num)', 'MasterDiagnosisController::hasil/$1');

});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}