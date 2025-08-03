<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class CorsFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // You can add pre-flight request handling here if needed
        return $request;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $config = config('Cors');
        
        // Allow specific origins
        $origin = $request->getHeaderLine('Origin');
        if (in_array($origin, $config->allowedOrigins)) {
            $response->setHeader('Access-Control-Allow-Origin', $origin);
        }

        // Allow methods
        $response->setHeader('Access-Control-Allow-Methods', implode(', ', $config->allowedMethods));
        
        // Allow headers
        $response->setHeader('Access-Control-Allow-Headers', implode(', ', $config->allowedHeaders));
        
        // Allow credentials
        if ($config->allowCredentials) {
            $response->setHeader('Access-Control-Allow-Credentials', 'true');
        }

        return $response;
    }
}
