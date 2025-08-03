<?php

namespace App\Controllers;

use App\Models\UserModel;
use OTPHP\TOTP;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class TwoFAController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Step 1: Show QR & enable 2FA (for admin only)
     */
    public function enable()
    {
        $session = session();
        if (!$session->get('logged_in') || $session->get('role') != 1) {
            return redirect()->to('AdministratorSign-In');
        }

        // If already enabled, skip
        $admin = $this->userModel->getUserById($session->get('user_id'));
        if (!empty($admin['is_2fa_enabled'] ?? null)) {
            return redirect()->to('admin');
        }

        // Create secret and store temporarily
        if (!$session->has('temp_totp_secret')) {
            $totp = TOTP::create();
            $label = $admin['username'] ?? $admin['email'] ?? 'admin';
            $totp->setLabel($label);
            $totp->setIssuer('MentalCare');
            $session->set('temp_totp_secret', $totp->getSecret());
        } else {
            $totp = TOTP::create($session->get('temp_totp_secret'));
            $label = $admin['username'] ?? $admin['email'] ?? 'admin';
            $totp->setLabel($label);
            $totp->setIssuer('MentalCare');
        }

        // Generate QR code PNG data URI
        $qrCode = new QrCode(
            data: $totp->getProvisioningUri(),
            size: 250,
            margin: 10
        );
        $writer = new PngWriter();
        $dataUri = $writer->write($qrCode)->getDataUri();

        return view('admin/auth/enable_2fa', [
            'qr'   => $dataUri,
            'title' => 'Aktifkan 2FA'
        ]);
    }

    public function enableVerify()
    {
        $session = session();
        $code = trim($this->request->getPost('code'));
        $secret = $session->get('temp_totp_secret');
        if (!$secret) {
            return redirect()->to('admin/enable-2fa');
        }
        $totp = TOTP::create($secret);
        if ($totp->verify($code, null, 1)) {
            // Save to DB
            $this->userModel->update($session->get('user_id'), [
                'totp_secret'     => $secret,
                'is_2fa_enabled' => 1
            ]);
            $session->remove('temp_totp_secret');
            $session->set(['2fa_verified' => true, 'is_2fa_enabled' => 1]);
            return redirect()->to('admin')->with('success', '2FA berhasil diaktifkan.');
        }
        return redirect()->back()->with('error', 'Kode tidak valid');
    }

    /**
     * Step 2: Verify during login
     */
    public function verify()
    {
        $session = session();
        if (!$session->has('pending_2fa_user')) {
            return redirect()->to('AdministratorSign-In');
        }
        return view('admin/auth/verify_2fa');
    }

    public function verifyProcess()
    {
        $session = session();
        $userId = $session->get('pending_2fa_user');
        $code   = trim($this->request->getPost('code'));
        $user   = $this->userModel->getUserById($userId);
        if (!$user) {
            return redirect()->to('AdministratorSign-In');
        }
        $totp = TOTP::create($user['totp_secret']);
        if ($totp->verify($code, null, 1)) {
            // success
            $session->remove('pending_2fa_user');
            $session->set([
                'logged_in'     => true,
                '2fa_verified'  => true,
                'user_id'       => $user['id_user'],
                'username'      => $user['username'],
                'nama_lengkap'  => $user['nama_lengkap'],
                'role'          => $user['role'],
                'is_2fa_enabled' => 1
            ]);
            return redirect()->to('admin');
        }
        return redirect()->back()->with('error', 'Kode 2FA salah');
    }

    /**
     * Disable 2FA for logged in admin
     */
    public function disable()
    {
        $session = session();
        if (!$session->get('logged_in') || $session->get('role') != 1) {
            return redirect()->to('AdministratorSign-In');
        }

        // Update DB
        $this->userModel->update($session->get('user_id'), [
            'is_2fa_enabled' => 0,
            'totp_secret'    => null
        ]);

        // Update session
        $session->set('is_2fa_enabled', 0);

        return redirect()->back()->with('success', 'Two-Factor Authentication dinonaktifkan.');
    }
}
