<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\UserActivityModel;
use App\Models\ResetPasswordModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ResetPasswordController extends BaseController
{
    public function forgotPassword()
    {
        return view('diagnosis/auth/lupa-password');
    }

    public function processForgotPassword()
    {
        $email = $this->request->getPost('email');

        $userModel = new UserModel();
        $user = $userModel->getUserByEmail($email);

        if ($user) {
            $token = bin2hex(random_bytes(32));

            date_default_timezone_set('Asia/Jakarta');

            $resetModel = new ResetPasswordModel();
            $resetModel->insert([
                'id_user' => $user['id_user'],
                'token' => $token,
                'expires_at' => date('Y-m-d H:i:s', strtotime('+5 minute')),
            ]);

            $resetLink = base_url('reset-password/' . $token);
            $mail = new PHPMailer(true);

            try {
                $mail = new PHPMailer();
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = '8farhanmaulana@gmail.com';
                $mail->Password = 'mkufhinrfaxvrwmu';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('8farhanmaulana@gmail.com', 'Reset Password');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Reset Password - MentalCare';
                
                // Build email template
                $emailMessage = '<html>';
                $emailMessage .= '<head>';
                $emailMessage .= '<style>';
                $emailMessage .= '.body { font-family: Arial, sans-serif; color: #333; }';
                $emailMessage .= '.container { max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f7f7f7; }';
                $emailMessage .= '.logo { display: block; margin: 0 auto; width: 50px; height: 50px; }';
                $emailMessage .= 'h1 { text-align: center; margin-bottom: 20px; }';
                $emailMessage .= 'table { width: 100%; border-collapse: collapse; }';
                $emailMessage .= 'td { padding: 10px; text-align: center; }';
                $emailMessage .= '.reset-link { background-color: #eee; padding: 15px; border-radius: 5px; }';
                $emailMessage .= '</style>';
                $emailMessage .= '</head>';
                $emailMessage .= '<body>';
                $emailMessage .= '<div class="container">';
                $logoPath = FCPATH . 'img/logo.png';
                $logoData = base64_encode(file_get_contents($logoPath));
                $emailMessage .= '<img src="data:image/png;base64,' . $logoData . '" alt="Logo" class="logo" style="width: 50px; height: 50px;">';
                $emailMessage .= '<h1>Reset Password</h1>';
                $emailMessage .= '<p>Silakan klik link di bawah ini untuk mereset password Anda:</p>';
                $emailMessage .= '<div class="reset-link">';
                $emailMessage .= '<a href="' . $resetLink . '">' . $resetLink . '</a>';
                $emailMessage .= '</div>';
                $emailMessage .= '<p><small>Link ini akan kadaluarsa dalam 5 menit.</small></p>';
                $emailMessage .= '</div>';
                $emailMessage .= '</body>';
                $emailMessage .= '</html>';
                
                $mail->Body = $emailMessage;

                $mail->send();
                
                $session = \Config\Services::session();
                $session->setFlashdata('success', 'Email reset password telah dikirim. Silakan periksa email Anda.');
                return redirect()->to('forgot-password');
            } catch (Exception $e) {
                $session = \Config\Services::session();
                $session->setFlashdata('error', 'Gagal mengirim email reset password. Silakan coba lagi.');
                return redirect()->back();
            }
        } else {
            $session = \Config\Services::session();
            $session->setFlashdata('error', 'Email tidak terdaftar.');
            return redirect()->back();
        }
    }

    public function showResetForm($token)
    {
        $resetModel = new ResetPasswordModel();
        $resetData = $resetModel->getResetDataByToken($token);

        if (!$resetData) {
            return redirect()->to('login-user')->with('error', 'Token tidak ditemukan atau sudah digunakan!');
        }

        date_default_timezone_set('Asia/Jakarta');
        $expiresAt = strtotime($resetData['expires_at']);
        $currentTimestamp = time();
        if ($currentTimestamp > $expiresAt) {
            return redirect()->to('login-user')->with('error', 'Token expired karena sudah melebihi batas waktu (5 Menit).');
        }

        return view('diagnosis/auth/verifikasi-password', ['token' => $token]);
    }

    public function reset()
    {
        $token = $this->request->getPost('token');
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        // Validasi password match
        if ($newPassword !== $confirmPassword) {
            return redirect()->to('/reset-password/' . $token)
                           ->with('error', 'Password dan konfirmasi password tidak cocok.');
        }

        // Validasi form
        $rules = [
            'new_password' => [
                'rules' => 'required|min_length[8]|regex_match[/^(?=.*[A-Z])(?=.*\d)(?=.*[@\.\,\!\#\$\%\^\&\*\(\)\-\_\+\=\?\:\;\<\>\{\}\[\]])/]',
                'errors' => [
                    'required' => 'Password baru harus diisi.',
                    'min_length' => 'Password minimal 8 karakter.',
                    'regex_match' => 'Password harus memiliki setidaknya 8 karakter dengan disertai huruf kapital, angka, dan tanda unik seperti (.,@$)'
                ]
            ],
            'confirm_password' => [
                'rules' => 'matches[new_password]',
                'errors' => [
                    'matches' => 'Konfirmasi password tidak cocok dengan password baru.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/reset-password/' . $token)
                           ->withInput()
                           ->with('error', $this->validator->listErrors());
        }

        // Cek validitas token
        $resetModel = new ResetPasswordModel();
        $resetData = $resetModel->getResetDataByToken($token);

        if (!$resetData) {
            return redirect()->to('forgot-password')
                           ->with('error', 'Token tidak valid atau sudah digunakan!');
        }

        // Cek expired token
        date_default_timezone_set('Asia/Jakarta');
        $expiresAt = strtotime($resetData['expires_at']);
        $currentTimestamp = time();
        
        if ($currentTimestamp > $expiresAt) {
            return redirect()->to('login-user')
                           ->with('error', 'Token telah kadaluarsa (batas waktu 5 menit).');
        }

        // Update password user
        $userModel = new UserModel();
        $user = $userModel->find($resetData['id_user']);

        if (!$user) {
            return redirect()->to('forgot-password')
                           ->with('error', 'User tidak ditemukan!');
        }

        // Update password dan hapus token
        $userModel->update($user['id_user'], [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT)
        ]);

        // Catat aktivitas reset password
        $activityLogModel = new UserActivityModel();
        $activityLogModel->insert([
            'id_user' => $user['id_user'],
            'activity_description' => 'Pengguna mereset password mereka melalui fitur lupa password.'
        ]);

        $resetModel->delete($resetData['id_reset_pass']);

        return redirect()->to('login-user')
                       ->with('success', 'Password berhasil direset! Silakan login dengan password baru.');
    }
}
