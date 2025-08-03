<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Cors extends BaseConfig
{
    public $allowedOrigins = [
        'http://localhost:8080',
        'http://localhost'
    ];

    public $allowedMethods = ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'];
    public $allowedHeaders = ['Content-Type', 'Authorization'];
    public $allowCredentials = true;
}
