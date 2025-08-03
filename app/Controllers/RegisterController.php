<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\OtpModel;
use PHPMailer\PHPMailer\PHPMailer;

class RegisterController extends BaseController
{
    public function register()
    {
        helper(['form']);
        $session = session();

        // Jika sudah ada session registrasi yang aktif, arahkan ke verifikasi
        $registrationData = $session->getTempdata('registration_data');
        if ($registrationData) {
            return redirect()->to('verify-otp')
                ->with('info', 'Silakan selesaikan verifikasi email Anda untuk melanjutkan pendaftaran.');
        }

        // Handle form submission
        if ($this->request->getMethod() === 'post') {
            $model = new UserModel();

            // Validasi form
            $rules = [
                'nama_lengkap' => 'required',
                'email' => 'required|valid_email',
                'password' => 'required|min_length[8]|regex_match[/^(?=.*[A-Z])(?=.*\d)(?=.*[@\.\,\!\#\$\%\^\&\*\(\)\-\_\+\=\?\:\;\<\>\{\}\[\]])/]',
                'confirm_password' => 'required|matches[password]'
            ];

            $errors = [
                'nama_lengkap' => [
                    'required' => 'Nama lengkap harus diisi'
                ],
                'email' => [
                    'required' => 'Email harus diisi',
                    'valid_email' => 'Format email tidak valid'
                ],
                'password' => [
                    'required' => 'Password harus diisi',
                    'min_length' => 'Password minimal 8 karakter',
                    'regex_match' => 'Password harus memiliki minimal 8 karakter dengan huruf kapital, angka, dan karakter khusus'
                ],
                'confirm_password' => [
                    'required' => 'Konfirmasi password harus diisi',
                    'matches' => 'Konfirmasi password tidak cocok dengan password'
                ]
            ];

            if (!$this->validate($rules, $errors)) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', $this->validator->getErrors());
            }

            $data = [
                'nama_lengkap' => $this->request->getPost('nama_lengkap'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
            ];

            // Cek email sudah terdaftar
            $existingEmail = $model->where('email', $data['email'])->first();
            if ($existingEmail) {
                return redirect()->back()
                    ->withInput()
                    ->with('errorr', 'Email sudah terdaftar. Silakan gunakan email lain atau login jika ini adalah email Anda.');
            }

            // Generate dan kirim OTP
            $otp = $this->generateOTP();
            if ($this->sendOTPByEmail($data['email'], $otp)) {
                // Set session data dengan timeout 5 menit
                $session->setTempdata('registration_data', $data, 300);
                $session->set('registration_email', $data['email']);
                
                return redirect()->to('verify-otp')
                    ->with('success', 'Kami telah mengirim kode verifikasi ke email Anda. Silakan periksa kotak masuk atau folder spam.');
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Maaf, terjadi kesalahan saat mengirim kode verifikasi. Silakan coba lagi.');
        }

        return view('diagnosis/auth/register');
    }

    public function resendOTP()
    {
        $session = session();
        $registrationData = $session->getTempdata('registration_data');

        if (!$registrationData) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Sesi registrasi telah berakhir'
            ]);
        }

        // Generate OTP baru
        $newOtp = $this->generateOTP();

        // Hapus OTP lama dari database
        $model = new OTPModel();
        $model->where('email', $registrationData['email'])->delete();

        // Kirim OTP baru
        if ($this->sendOTPByEmail($registrationData['email'], $newOtp)) {
            // Reset session timeout
            $session->setTempdata('registration_data', $registrationData, 300);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'OTP baru telah dikirim'
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal mengirim OTP'
        ]);
    }

    public function verifyOTP()
    {
        helper(['form']);
        $session = session();
        
        // Ambil data registrasi dari session
        $registrationData = $session->getTempdata('registration_data');
        $registrationEmail = $session->get('registration_email');

        // Jika tidak ada data registrasi, kembalikan ke halaman register
        if (!$registrationData || !$registrationEmail) {
            $session->remove('registration_email');
            $session->remove('otp_attempts');
            return redirect()->to('register')
                ->with('errorr', 'Sesi pendaftaran telah berakhir. Silakan daftar ulang.');
        }

        // Jika email tidak cocok, batalkan proses
        if ($registrationData['email'] !== $registrationEmail) {
            $session->removeTempdata('registration_data');
            $session->remove('registration_email');
            $session->remove('otp_attempts');
            return redirect()->to('register')
                ->with('errorr', 'Terjadi ketidaksesuaian data. Untuk keamanan, silakan daftar ulang.');
        }

        // Handle form submission
        if ($this->request->getMethod() === 'post') {
            $otp = $this->request->getPost('otp');

            if ($this->verifyOTPFromDB($otp, $registrationEmail)) {
                $model = new UserModel();
                
                try {
                    if ($model->insert($registrationData)) {
                        // Hapus semua data session setelah berhasil
                        $this->deleteOTPFromDB($otp);
                        $session->removeTempdata('registration_data');
                        $session->remove('registration_email');
                        $session->remove('otp_attempts');
                        
                        return redirect()->to('login-user')
                            ->with('success', 'Selamat! Akun Anda berhasil dibuat. Silakan login untuk mengakses layanan MentalCare.');
                    }
                } catch (\Exception $e) {
                    log_message('error', 'Error saat menyimpan data pengguna: ' . $e->getMessage());
                    return redirect()->back()
                        ->with('error', 'Maaf, terjadi kesalahan saat membuat akun. Silakan coba lagi.');
                }
            }

            // Tambah hitungan percobaan OTP
            $attempts = $session->get('otp_attempts', 0) + 1;
            $session->set('otp_attempts', $attempts);

            if ($attempts >= 3) {
                // Hapus semua data session jika melebihi batas percobaan
                $session->removeTempdata('registration_data');
                $session->remove('registration_email');
                $session->remove('otp_attempts');
                return redirect()->to('register')
                    ->with('errorr', 'Untuk keamanan, sesi verifikasi telah berakhir karena terlalu banyak percobaan. Silakan daftar ulang.');
            }

            return redirect()->back()
                ->with('error', 'Kode verifikasi tidak valid. Sisa ' . (3 - $attempts) . ' kali kesempatan.');
        }

        return view('diagnosis/auth/verifikasi');
    }

    protected function sendOTPByEmail($toEmail, $otp)
    {
        $model = new OTPModel();

        try {
            // Hapus OTP lama jika ada
            $model->where('email', $toEmail)->delete();

            // Simpan OTP baru ke database
            $model->insert([
                'email' => $toEmail,
                'otp' => $otp,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            $email = \Config\Services::email();
            $email->setFrom('8farhanmaulana@gmail.com', 'MentalCare');
            $email->setTo($toEmail);
            $email->setSubject('Kode OTP Registrasi MentalCare');

            // Logo dalam base64
            $logoPath = FCPATH . 'img/logo.png';
            $logoData = base64_encode(file_get_contents($logoPath));

            $emailMessage = '
            <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f7f7f7;">
                <div style="text-align: center; margin-bottom: 20px;">
                    <img src="data:image/png;base64,' . $logoData . '" alt="MentalCare Logo" style="width: 100px; height: 100px;">
                </div>
                <div style="background-color: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                    <h2 style="color: #0a2342; text-align: center; margin-bottom: 20px;">Verifikasi Email MentalCare</h2>
                    <p style="color: #666; line-height: 1.6;">Terima kasih telah mendaftar di MentalCare. Berikut adalah kode OTP Anda:</p>
                    <div style="text-align: center; margin: 30px 0;">
                        <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; display: inline-block;">
                            <h1 style="color: #D56062; font-size: 32px; letter-spacing: 5px; margin: 0;">' . $otp . '</h1>
                        </div>
                    </div>
                    <p style="color: #666; line-height: 1.6;">Kode OTP ini akan kadaluarsa dalam <strong>5 menit</strong>.</p>
                    <p style="color: #666; line-height: 1.6;">Jika Anda tidak merasa mendaftar di MentalCare, abaikan email ini.</p>
                    <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
                    <p style="color: #666; text-align: center; font-size: 14px;">Salam hangat,<br>Tim MentalCare</p>
                </div>
                <div style="text-align: center; margin-top: 20px; color: #999; font-size: 12px;">
                    <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
                </div>
            </div>';

            $email->setMessage($emailMessage);
            $email->setMailType('html');

            if ($email->send()) {
                log_message('info', 'OTP berhasil dikirim ke: ' . $toEmail);
                return true;
            } else {
                log_message('error', 'Gagal mengirim OTP: ' . $email->printDebugger(['headers']));
                return false;
            }
        } catch (\Exception $e) {
            log_message('error', 'Error saat mengirim OTP: ' . $e->getMessage());
            return false;
        }
    }

    protected function generateOTP()
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $otp = '';
        
        for ($i = 0; $i < 6; $i++) {
            $otp .= $characters[random_int(0, strlen($characters) - 1)];
        }
        
        return $otp;
    }

    protected function verifyOTPFromDB($otp, $email)
    {
        try {
            $model = new OTPModel(); 
            $otpData = $model->where([
                'otp' => $otp,
                'email' => $email
            ])->first();

            if ($otpData) {
                $createdAt = strtotime($otpData['created_at']);
                $currentTime = time();
                
                // Verifikasi OTP belum expired (5 menit)
                if ($currentTime - $createdAt <= 300) {
                    return true;
                }
                
                // Jika OTP expired, hapus dari database
                $this->deleteOTPFromDB($otp);
            }
            
            return false;
        } catch (\Exception $e) {
            log_message('error', 'Error saat verifikasi OTP: ' . $e->getMessage());
            return false;
        }
    }

    protected function deleteOTPFromDB($otp)
    {
        try {
            $model = new OTPModel();
            return $model->where('otp', $otp)->delete();
        } catch (\Exception $e) {
            log_message('error', 'Error saat menghapus OTP: ' . $e->getMessage());
            return false;
        }
    }
}
