<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function profile()
    {
        $session = session();
        $userId = $session->get('user_id');
        
        if (!$userId || !$session->get('logged_in')) {
            return redirect()->to('login-user')->with('error', 'Silakan login terlebih dahulu');
        }

        $user = $this->userModel->getUserById($userId);

        if (!$user) {
            return redirect()->to('login-user')->with('error', 'User tidak ditemukan');
        }

        return view('user/profile', [
            'user' => $user,
            'title' => 'Profil Pengguna'
        ]);
    }

    public function updateProfile()
    {
        $session = session();
        $userId = $session->get('user_id');
        
        if (!$userId || !$session->get('logged_in')) {
            return redirect()->to('login-user')->with('error', 'Silakan login terlebih dahulu');
        }

        $user = $this->userModel->getUserById($userId);

        if (!$user) {
            return redirect()->to('login-user')->with('error', 'User tidak ditemukan');
        }

        $rules = [
            'nama_lengkap' => 'required',
            'email' => 'required|valid_email',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'pekerjaan' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email' => $this->request->getPost('email'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'pekerjaan' => $this->request->getPost('pekerjaan')
        ];

        // Check if password is being updated
        $password = $this->request->getPost('password');
        if ($password) {
            $passwordRules = [
                'password' => 'required|min_length[8]|regex_match[/^(?=.*[A-Z])(?=.*\d)(?=.*[@\.\,\!\#\$\%\^\&\*\(\)\-\_\+\=\?\:\;\<\>\{\}\[\]])/]',
                'password_confirm' => 'required|matches[password]'
            ];

            if (!$this->validate($passwordRules)) {
                return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
            }

            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // Check if email is changed and already exists
        if ($data['email'] !== $user['email']) {
            $existingEmail = $this->userModel->where('email', $data['email'])
                                           ->where('id_user !=', $userId)
                                           ->first();
            if ($existingEmail) {
                return redirect()->back()->withInput()->with('error', ['email' => 'Email sudah digunakan']);
            }
        }

        if ($this->userModel->update($userId, $data)) {
            return redirect()->back()->with('success', 'Profil berhasil diperbarui');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal memperbarui profil');
    }
}
