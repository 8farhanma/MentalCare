<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\GoogleClient;

class GoogleAuth extends Controller
{
    protected $client;
    
    public function __construct()
    {
        $this->client = GoogleClient::getClient();
        
        // Set your redirect URI
        $this->client->setRedirectUri(site_url('auth/google/callback'));
        
        // Add the scopes you need
        $this->client->addScope([
            'email',
            'profile',
        ]);
    }
    
    public function login()
    {
        // Generate the Google login URL and redirect
        $authUrl = $this->client->createAuthUrl();
        return redirect()->to($authUrl);
    }
    
    public function callback()
    {
        try {
            // Get the authorization code from the query parameters
            $code = $this->request->getGet('code');
            
            if ($code) {
                // Exchange the authorization code for an access token
                $token = $this->client->fetchAccessTokenWithAuthCode($code);
                $this->client->setAccessToken($token);
                
                // Get user information
                $oauth2 = new \Google\Service\Oauth2($this->client);
                $userInfo = $oauth2->userinfo->get();
                
                // Here you can handle the user information
                // For example, log the user in or create a new user account
                
                return redirect()->to('/dashboard'); // Redirect to your dashboard
            }
        } catch (\Exception $e) {
            log_message('error', 'Google OAuth error: ' . $e->getMessage());
            return redirect()->to('/login')->with('error', 'Authentication failed. Please try again.');
        }
    }
}
