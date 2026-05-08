<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class AuthGroups extends BaseConfig
{
    public array $hiddenLoginRoutes;

    public array $defaultRedirects = [
        'sportif' => '/suggestions',
        'admin'   => '/admin',
        'coach'   => '/coach',
    ];

    public function __construct()
    {
        parent::__construct();

        $this->hiddenLoginRoutes = [
            'admin' => env('auth.hiddenAdminRoute', 'espace-securise/portail-admin-9xk7/connexion'),
            'coach' => env('auth.hiddenCoachRoute', 'espace-securise/portail-coach-4mp2/connexion'),
        ];
    }
}
