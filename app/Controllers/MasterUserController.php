<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\UserActivityModel;

class MasterUserController extends BaseController
{
    public function index()
    {
        $model = new UserModel();
        $dataAdmin = $model->findAll();

        $data = [
            'title' => 'Master Akun',
            'dataAdmin' => $dataAdmin
        ];
        return view('admin/master_admin/index', $data);
    }

    public function indexUser()
    {
        $model = new UserModel();
        $dataUser = $model->findAll();

        $data = [
            'title' => 'Master Akun',
            'dataUsers' => $dataUser
        ];
        return view('admin/master_user/index', $data);
    }

    public function truncateData()
    {
        $adminModel = new UserModel();
        $adminModel->truncate(); 

        session()->setFlashdata('success', 'Keseluruhan data admin berhasil dihapus.');

        return redirect()->back();
    }

    public function truncateDataUser()
    {
        $userModel = new UserModel();
        // Hapus hanya pengguna dengan role = 2 (User) tanpa menghapus Admin (role = 1)
        $userModel->where('role', 2)->delete();

        session()->setFlashdata('success', 'Keseluruhan data user (non-admin) berhasil dihapus.');

        return redirect()->back();
    }

    public function delete($id_admin)
    {
        $userModel = new UserModel();
        // $diagnosisGejalaModel = new DiagnosisGejalaModel();

        $userModel->delete($id_admin);

        return redirect()->to('admin/master_admin')->with('success', 'Data Admin berhasil dihapus.');
    }

    public function hapus($id_user)
    {
        $userModel = new UserModel();

        // Soft delete user dengan role 2 (User)
        $user = $userModel->where('id_user', $id_user)->where('role', 2)->first();
        if ($user) {
            $userModel->delete($id_user);
            return redirect()->to('admin/master_user')->with('success', 'Data User berhasil dipindahkan ke Recycle Bin.');
        }

        return redirect()->to('admin/master_user')->with('error', 'Data User tidak ditemukan atau bukan merupakan user.');
    }


    public function activity($id_user)
    {
        $userModel = new UserModel();
        $activityModel = new UserActivityModel();

        $user = $userModel->find($id_user);

        if (!$user || $user['role'] != 2) {
            return redirect()->to('admin/master_user')->with('error', 'User tidak ditemukan atau bukan merupakan user.');
        }

        $activities = $activityModel->where('id_user', $id_user)->orderBy('created_at', 'DESC')->findAll();

        $data = [
            'title'      => 'Aktivitas Pengguna: ' . htmlspecialchars($user['nama_lengkap']),
            'user'       => $user,
            'activities' => $activities,
        ];

        return view('admin/master_user/activity_log', $data);
    }
}
