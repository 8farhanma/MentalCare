<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = Services::session();

        // Get current path
        $currentPath = $request->uri->getPath();

        // Define public routes that don't need authentication
        $publicRoutes = [
            'login-user',
            'login-google',
            'login-google/callback',
            'register',
            'verify-otp',
            'forgot-password',
            'AdministratorSign-In',
            'admin/verify-2fa',
            'admin/enable-2fa',
            ''  // Root path
        ];

        // If this is a public route, allow access
        if (in_array($currentPath, $publicRoutes)) {
            return $request;
        }

        $isAdmin = $session->get('logged_in');
        $isUser  = $session->get('login_diagnosis');
        $role    = $session->get('role');

        // Handle admin routes
        if (strpos($currentPath, 'admin') === 0) {
            // Jika 2FA belum diverifikasi
            if ($session->get('logged_in') && $role == 1 && $session->get('is_2fa_enabled') && !$session->get('2fa_verified')) {
                // Jika sudah berada di halaman verifikasi, biarkan
                if (strpos($currentPath, 'admin/verify-2fa') !== 0 && strpos($currentPath, 'admin/enable-2fa') !== 0) {
                    return redirect()->to('admin/verify-2fa');
                }
            }
            if (!$isAdmin || $role != 1) {
                return redirect()->to('AdministratorSign-In')
                    ->with('error', 'Anda harus login sebagai admin terlebih dahulu');
            }
            return $request;
        }

        // Handle user routes
        if (strpos($currentPath, 'user') === 0) {
            if (!$isUser || $role != 2) {
                return redirect()->to('login-user')
                    ->with('error', 'Anda harus login terlebih dahulu');
            }
            return $request;
        }

        // For any other protected routes
        if (!$isAdmin && !$isUser) {
            return redirect()->to('login-user')
                ->with('error', 'Anda harus login terlebih dahulu');
        }

        return $request;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
