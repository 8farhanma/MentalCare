<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Traits\SoftRestoreTrait;

class UserModel extends Model
{
    use SoftRestoreTrait;
    protected $table = 'tbl_user';
    protected $primaryKey = 'id_user';
    protected $allowedFields = ['username', 'password', 'nama_lengkap', 'email', 'role', 'totp_secret', 'is_2fa_enabled'];

    // Soft Deletes
    protected $useSoftDeletes = true;
    protected $deletedField   = 'deleted_at';
    protected $useTimestamps = true;

    public function restoreAll()
    {
        return $this->builder()
            ->where($this->deletedField . ' IS NOT NULL')
            ->set($this->deletedField, null)
            ->update();
    }

    // Fungsi untuk mendapatkan data pengguna berdasarkan email
    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    // Fungsi untuk mendapatkan data pengguna berdasarkan username
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    // Fungsi untuk mendapatkan data pengguna berdasarkan ID
    public function getUserById($id)
    {
        return $this->find($id);
    }

    // Fungsi untuk login gabungan (admin/user)
    public function login($identity, $password, $role = null)
    {
        // Bisa login pakai username atau email
        $user = $this->where(
            is_numeric($identity) ? 'id_user' : (filter_var($identity, FILTER_VALIDATE_EMAIL) ? 'email' : 'username'),
            $identity
        )->first();
        if ($user && password_verify($password, $user['password'])) {
            if ($role === null || $user['role'] == $role) {
                return $user;
            }
        }
        return false;
    }
}
