<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        if (session()->get('user_id')) {
            return redirect()->to('/suggestions');
        }

        return redirect()->to('/connexion');
    }
}
