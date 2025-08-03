<?php

namespace Config;

use Google_Client;
use Google\Client;

class GoogleClient
{
    public static function getClient()
    {
        $client = new Client();
        
        // Set the client ID from your .env file
        $client->setClientId(getenv('GOOGLE_CLIENT_ID'));
        
        // Set SSL verification options
        $client->setHttpClient(
            new \GuzzleHttp\Client([
                'verify' => FCPATH . 'cacert.pem',  // We'll download this file next
                'timeout' => 30,
                'connect_timeout' => 30
            ])
        );
        
        // Add other necessary configuration
        $client->setAccessType('offline');
        $client->setApprovalPrompt('force');
        $client->setIncludeGrantedScopes(true);
        
        return $client;
    }
}
