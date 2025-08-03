<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\UserActivityModel;
use App\Models\GoogleModel;
use Google_Client;
use GuzzleHttp\Exception\ConnectException;

class Auth extends BaseController
{

    private function initializeGoogleClient()
    {
        $client = new Google_Client();
        $client->setClientId(getenv('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(getenv('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(base_url('login-google/callback'));
        $client->addScope('email');
        $client->addScope('profile');
        return $client;
    }

    public function showLogin()
    {
        $session = session();
        
        if ($session->get('logged_in') || $session->get('login_diagnosis')) {
            return redirect()->back()->with('error', 'Anda harus logout terlebih dahulu');
        }
        return view('admin/auth/login');
    }

    public function showLoginUser()
    {
        $session = session();
        
        if ($session->get('logged_in') || $session->get('login_diagnosis')) {
            return redirect()->back()->with('error', 'Anda harus logout terlebih dahulu');
        }
        return view('diagnosis/auth/login');
    }

    public function login()
    {
        $model = new UserModel();
        $inputUsername = $this->request->getPost('username');
        $password      = $this->request->getPost('password');

        // Throttling untuk admin: 5 percobaan gagal, tunggu 5 menit
        $session = session();
        $failedAttemptsAdmin = $session->get('admin_failed_attempts') ?? 0;
        if ($failedAttemptsAdmin >= 5) {
            $lastFailedAdmin = $session->get('admin_last_failed_attempt') ?? 0;
            $currentTime = time();
            if ($currentTime - $lastFailedAdmin < 300) { // 5 menit
                $remainingTimeAdmin = 300 - ($currentTime - $lastFailedAdmin);
                return redirect()->to('AdministratorSign-In')
                    ->withInput()
                    ->with('remainingTimeAdmin', $remainingTimeAdmin);
            }
        }

        // Gunakan helper login() agar validasi terpusat
        $user = $model->login($inputUsername, $password, 1);

        if ($user) {
            $session = session();
            // Reset percobaan gagal
            $session->remove('admin_failed_attempts');
            $session->remove('admin_last_failed_attempt');
            // Jika admin memiliki 2FA aktif, arahkan ke verifikasi
            if (!empty($user['is_2fa_enabled'] ?? null)) {
                $session->set('pending_2fa_user', $user['id_user']);
                return redirect()->to('admin/verify-2fa');
            }

            $session->set([
                'logged_in' => true,
                'user_id' => $user['id_user'],
                'username' => $user['username'],
                'nama_lengkap' => $user['nama_lengkap'],
                'role' => $user['role'],
                'is_2fa_enabled' => $user['is_2fa_enabled'] ?? 0
            ]);
            $alertMessage = "Selamat datang, " . $user['nama_lengkap'] . "!";
            return redirect()->to('admin')->with('logSuccess', $alertMessage);
        } else {
            // Tambah hitungan gagal
            $failedAttemptsAdmin++;
            $session->set('admin_failed_attempts', $failedAttemptsAdmin);
            $session->set('admin_last_failed_attempt', time());

            if ($failedAttemptsAdmin >= 5) {
                $remainingTimeAdmin = 300;
                return redirect()->to('AdministratorSign-In')
                    ->withInput()
                    ->with('remainingTimeAdmin', $remainingTimeAdmin)
                    ->with('error', 'Terlalu banyak percobaan gagal. Silakan tunggu 5 menit sebelum mencoba lagi.');
            }
            return redirect()->back()->withInput()->with('error', 'Username atau password tidak valid');
        }
    }

    public function loginUser()
    {
        $model = new UserModel();
        $inputEmail = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Validasi input kosong
        if (empty($inputEmail) || empty($password)) {
            return redirect()->to('login-user')->withInput()->with('error', 'Email dan password harus diisi');
        }

        // Validasi format email
        if (!filter_var($inputEmail, FILTER_VALIDATE_EMAIL)) {
            return redirect()->to('login-user')->withInput()->with('error', 'Format email tidak valid');
        }

        $failedAttempts = session()->get('failed_attempts') ?? 0;

        if ($failedAttempts >= 3) {
            $lastFailedAttempt = session()->get('last_failed_attempt') ?? 0;
            $currentTime = time();

            if ($currentTime - $lastFailedAttempt < 180) {
                $remainingTime = 180 - ($currentTime - $lastFailedAttempt);
                return redirect()->to('login-user')->withInput()->with('remainingTime', $remainingTime);
            }
        }

        // Gabungan login user: email & role=2
        $user = $model->login($inputEmail, $password, 2);
        if (!$user) {
            $failedAttempts++;
            session()->set('failed_attempts', $failedAttempts);
            session()->set('last_failed_attempt', time());

            if ($failedAttempts === 1 || $failedAttempts === 2) {
                return redirect()->to('login-user')->withInput()->with('error', 'Email atau password tidak valid');
            } elseif ($failedAttempts >= 3) {
                $remainingTime = 180;
                return redirect()->to('login-user')->withInput()->with('remainingTime', $remainingTime)->with('error', 'Terlalu banyak percobaan gagal. Silakan tunggu 3 menit sebelum mencoba lagi.');
            }
        }

        // Login berhasil
        session()->remove('failed_attempts');
        session()->remove('last_failed_attempt');

        $session = session();
        $session->set([
            'login_diagnosis' => true,
            'user_id' => $user['id_user'],
            'email' => $user['email'],
            'nama_lengkap' => $user['nama_lengkap'],
            'role' => $user['role']
        ]);

        // Log user activity
        $activityModel = new UserActivityModel();
        $activityModel->insert([
            'id_user' => $user['id_user'],
            'activity_description' => 'Pengguna berhasil login.'
        ]);

        $alertMessage = "Selamat datang, " . $user['nama_lengkap'] . "!";
        return redirect()->to('user/cek_diagnosis')->with('logSuccess', $alertMessage);
    }

    public function loginGoogle()
    {
        $client = $this->initializeGoogleClient();
        $authUrl = $client->createAuthUrl();
        return redirect()->to($authUrl);
    }

    public function googleCallback()
    {
        $client = $this->initializeGoogleClient();
        $code = $this->request->getGet('code');

        if ($code) {
            $token = $client->fetchAccessTokenWithAuthCode($code);
            if (!isset($token['error'])) {
                $oauth2Service = new \Google_Service_Oauth2($client);
                $googleUser = $oauth2Service->userinfo->get();

                $userModel = new \App\Models\UserModel();
                $user = $userModel->where('email', $googleUser->getEmail())->first();

                // If user doesn't exist, create a new one (register)
                if (!$user) {
                    $userData = [
                        'email'         => $googleUser->getEmail(),
                        'nama_lengkap'  => $googleUser->getName(),
                        'username'      => $googleUser->getEmail(), // Use email as username
                        'password'      => password_hash(random_bytes(16), PASSWORD_DEFAULT), // Set a random password
                        'role'          => 2, // User role
                        'is_active'     => 1, // Activate account immediately
                    ];
                    $userModel->insert($userData);
                    // Get the newly created user's data
                    $user = $userModel->where('email', $googleUser->getEmail())->first();
                }

                // Now, set the session for the logged-in user
                $session = session();
                $session->set([
                    'login_diagnosis' => true,
                    'user_id'         => $user['id_user'],
                    'email'           => $user['email'],
                    'nama_lengkap'    => $user['nama_lengkap'],
                    'role'            => $user['role']
                ]);

                $alertMessage = "Selamat datang, " . $user['nama_lengkap'] . "!";
                return redirect()->to('user/cek_diagnosis')->with('logSuccess', $alertMessage);

            } else {
                return redirect()->to('login-user')->with('error', 'Gagal mengotentikasi dengan Google.');
            }
        } else {
            return redirect()->to('login-user')->with('error', 'Kode otorisasi tidak ditemukan.');
        }
    }

    public function logout()
    {
        $session = session();
        $userId = $session->get('user_id');

        // Log user activity before destroying the session
        if ($userId && $session->get('role') == 2) {
            $activityModel = new UserActivityModel();
            $activityModel->insert([
                'id_user' => $userId,
                'activity_description' => 'Pengguna logout.'
            ]);
        }

        try {
            $client = $this->initializeGoogleClient();
            $client->revokeToken();
        } catch (ConnectException $e) {
            // Log error but continue logout process
            log_message('error', 'Failed to revoke Google token due to connection error: ' . $e->getMessage());
        }

        $session->destroy();

        return redirect()->to('/');
    }

    public function logoutExpertSystem()
    {
        $session = session();
        $userId = $session->get('user_id');

        // Log user activity before destroying the session
        if ($userId && $session->get('role') == 2) {
            $activityModel = new UserActivityModel();
            $activityModel->insert([
                'id_user' => $userId,
                'activity_description' => 'Pengguna logout dari sistem pakar.'
            ]);
        }

        $session->destroy();

        return redirect()->to('/');
    }
}